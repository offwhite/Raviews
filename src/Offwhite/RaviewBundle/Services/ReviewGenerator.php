<?php

namespace Offwhite\RaviewBundle\Services;

use Symfony\Component\Yaml\Parser;

/*
 * Loads arrays of placeholders by component type from
 * reviewGenerator.componentPath/*.yml files.
 *
 * Generates random reviews using reviewComponents.yml files and movie data
 */

class ReviewGenerator{

    private $availablePlaceholders = array();

    private $placeholdersBackup;

    private $usedPlaceholders;

    private $nonRandomTypes;

    /**
     * @param $pathToComponents
     */
    public function __construct($pathToComponents)
    {
        // load all components from yml files
        $this->loadComponents($pathToComponents);

        // define some components as ordered rather than random
        $this->nonRandomTypes = array('actor','character');
    }


    /**
     * Load all review components from yml files found in component dir
     * defined in parameters.yml: reviewGenerator.componentPath
     *
     * @param $pathToComponents
     * @return $this->availablePlaceholders
     */

    private function loadComponents($pathToComponents){

        $yaml = new Parser();

        $availableComponents = scandir($pathToComponents);

        foreach($availableComponents as $component){
            if (false !== strrpos($component, ".yml")){
                 // add this array to our available placeholders
                 $this->availablePlaceholders = array_merge(
                    $this->availablePlaceholders,
                    $yaml->parse(file_get_contents($pathToComponents.'/'.$component))
                );
            }
        }

        $this->placeholdersBackup = $this->availablePlaceholders;

        return $this->availablePlaceholders;
    }


    /*
     * Generate the review from available placeholders
     *
     * @param Offwhite\reviewBundle\Entity\Movie
     * @param integer|null $foundationIndex
     * @return a review entity
     */

    public function generateReview($movie, $foundationIndex = null){

        // reset used placeholders for each movie
        $this->usedPlaceholders = array();

        // reset available placeholders
        $this->availablePlaceholders = $this->placeholdersBackup;

        // set movie specific placeholders
        $this->setMoviePlaceholderValues($movie);

        // get the rating an define a foundation from it
        $foundationIndex = floor($movie->getRating() / 20);

        // select a random foundation if we haven't got one or if it's too high
        if (null === $foundationIndex || $foundationIndex > count($this->availablePlaceholders['foundations'])) {
            $foundationIndex = rand( 0, ( count($this->availablePlaceholders['foundations']) - 1) );
        }

        $foundation = $this->availablePlaceholders['foundations'][ $foundationIndex];

        // process all placeholders
        $review = $this->processPlaceholders($foundation);

        return $review;
    }

    /**
     * Process all placeholders in a string
     * @param $string
     * @return $string
     */
     private function processPlaceholders($string)
     {

         /*
          * some placeholders contain placeholders
          * so this has to be iterative.
          */

         while( false !== strrpos($string, '{') ){

             // loop through review and find placeholders
             preg_match_all("/{(.*?)}/", $string, $matches);

             foreach($matches[1] as $match){

                 // get placeholder
                 $placeholder = $this->getValueFromPlaceholder($match);

                 // replace the values
                 $string = str_replace('{'.$match.'}', $placeholder, $string);
             }
         }

         return $string;
     }

    /**
     * populates the availablePlaceholder arrays from the movie entity
     *
     * @param $movie \Offwhite\reviewBundle\Entity\Movie
     */
    private function setMoviePlaceholderValues($movie)
    {

        $actors = array();
        $characters = array();

        foreach ($movie->getCast() as $cast) {
            $castArray      = explode(' - ',$cast);
            $actors[]       = isset($castArray[0]) ? '<b>'.$castArray[0].'</b>' : 'one actor';
            $characters[]   = isset($castArray[1]) ? '<b>'.$castArray[1].'</b>' : 'one character';
        }

        // store the arrays
        $this->availablePlaceholders['actor'] = $actors;
        $this->availablePlaceholders['director'] = array( '<b>'.$movie->getDirector().'</b>' );
        $this->availablePlaceholders['character'] = $characters;
        $this->availablePlaceholders['title'] = array($movie->getTitle());
        $this->availablePlaceholders['year'] = array($movie->getYear());
        $this->availablePlaceholders['runtime'] = array($movie->getRuntime());

        return $this;
    }


    /**
     * We want to ensure that "location_01" will return the same
     * value for each request during a single review generation
     *
     * returns a placeholder from the usedPlaceholders array
     *
     * if placeholder isn't found in usedPlaceholders array
     *  - generate one from the array defined by type
     *
     * @param $placeholder
     * @return string
     */
    private function getValueFromPlaceholder($placeholder)
    {
        /*
         * Load an existing value if we have one
         */

        if ( isset($this->usedPlaceholders[$placeholder]) ) {
            return $this->usedPlaceholders[$placeholder];
        }

        /*
         * This placeholder hasn't been requested: make one
         */

        $matchArr = explode('_',$placeholder);

        // determine placeholder type
        $type = $matchArr[0];

        /*
         * check we have a component type available
         */
        if (!isset($this->availablePlaceholders[$type])){
            return $placeholder;
        }

        /*
         * determine array index - randomly selected if allowed by this type
         */
        if (in_array($type, $this->nonRandomTypes)) {
            // use index as defined in origin - eg. actor_01 will be the first in the array
            $arrIndex = intval($matchArr[1]) - 1;
        } else{
            // generate a random index
            $arrIndex = rand( 0, (count($this->availablePlaceholders[$type])  - 1) );
        }

        /*
         * ensure the index is in the type array
         */
        if ( isset($this->availablePlaceholders[$type][$arrIndex])) {

            $value = $this->availablePlaceholders[$type][$arrIndex];

        }else{
            $value = $placeholder;
        }

        // record we have used this placeholder
        $this->usedPlaceholders[$placeholder] = $value;

        return $value;
    }
}