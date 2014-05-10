<?php

namespace Offwhite\RaviewBundle\Services;

use Offwhite\RaviewBundle\Entity\Movie;

/*
 * TheMovieDataBase interface
 * handles all requests to tmdb api
 * parses api response, generates random reviews
 * and persists entities
 */

class Tmdb{

    private $apiKey;
    private $em;
    private $reviewGenerator;

    /**
     * @param $em
     * @param $apiKey
     * @param $reviewGenerator
     */
    public function __construct($em, $apiKey, $reviewGenerator)
    {
        $this->em = $em;
        $this->apiKey = $apiKey;
        $this->reviewGenerator = $reviewGenerator;
    }


    /**
     * Executes an apiCall with $query and validates the response before
     * looping through each result requesting all data and creating a
     * \Offwhite\RaviewBundle\Entity\Movie for each
     *
     * @param $query
     * @return array|bool
     */
    public function searchByTitle($query)
    {

        $moviesArray = array();

        $apiResponse = ($this->apiCall(null, $query));

        // TODO: validate response from apiCall

        if (!isset($apiResponse->results)) {
            return false;
        }

        // go through the results and call each movie
        foreach ( $apiResponse->results as $result)
        {
            $apiMovie = ($this->apiCall($result->id));

            // generate an entity
            $movie = $this->createEntity($apiMovie);
            if (false !== $movie) {
                $moviesArray[] = $movie;
            }
        }

        $this->em->flush();

        return $moviesArray;
    }

    /**
     * Hydrate a movie entity from an apiMovieObject
     * Generates a review using reviewGenerator service
     *
     * @param $apiMovie
     * @return \Offwhite\RaviewBundle\Entity\Movie
     */
    Private function createEntity($apiMovie)
    {
        /*
         * Imdbid's are unique, return db entity if found
         * this increases db load but guarantees imdbId's are unique without generating an exception
         */
        $movie = $this->em->getRepository('OffwhiteRaviewBundle:Movie')->loadByImdbId($apiMovie->imdb_id);

        if (null !== $movie) {
            return $movie;
        }

        // parse release date
        $releaseDate = isset($apiMovie->release_date) ? explode('-',$apiMovie->release_date) : array(null);

        // we don't want to keep this movie if there is no cast
        // or it is not released yet
        // or it has no imdb id
        if (
                count($apiMovie->credits->cast) < 2
                || $releaseDate[0] > \idate('Y')
                || !isset($apiMovie->imdb_id)
            ) {
            return false;
        }

        // parse director
        $director = null;
        if (isset($apiMovie->credits->crew)) {
            foreach ($apiMovie->credits->crew as $crew){
                if ('Director' == $crew->job) {
                    $director = $crew->name;
                }
            }
        }

        // parse cast
        $parsedCast = array();
        if (isset($apiMovie->credits->cast)) {
            foreach ($apiMovie->credits->cast as $cast){
                $parsedCast[] = $cast->name.' - '.$cast->character;
            }
        }

        // generate the rating
        $rating = rand(0, 99);

        $movie = new Movie();
        $movie->setTitle($apiMovie->original_title);
        $movie->setDirector($director);
        $movie->setRating($rating);
        $movie->setRuntime($apiMovie->runtime);
        $movie->setTagLine($apiMovie->tagline);
        $movie->setOverview($apiMovie->overview);
        $movie->setImdbId($apiMovie->imdb_id);
        $movie->setCast(implode('||', $parsedCast));
        $movie->setImagePoster($apiMovie->poster_path);
        $movie->setImageBackground($apiMovie->backdrop_path);
        $movie->setYear($releaseDate[0]);
        $movie->setCreated(new \DateTime());

        // generate review
        $review = $this->reviewGenerator->generateReview($movie);

        $movie->setRaview($review);

        $this->em->persist($movie);


        return $movie;
    }

    /**
     * makes the request to the movie db api
     *
     * @param integer|null $id
     * @param string|null $titleQuery
     * @return \stdObject
     */
    Private function apiCall($id = null, $titleQuery = null)
    {

        if( null == $id && null != $titleQuery ) {

            // search for a movie by title
            $url = "http://api.themoviedb.org/3/search/movie?query=".urlencode($titleQuery);
        }
        elseif( null != $id) {

            // load a movie by id
            $url = "https://api.themoviedb.org/3/movie/".$id."?append_to_response=credits";

        }

        // add the api key
        $url .= "&api_key=".$this->apiKey;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $response = json_decode(curl_exec($curl));

        return $response;
    }
}