<?php

namespace Offwhite\RaviewBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Offwhite\RaviewBundle\Entity\Movie;
use Offwhite\RaviewBundle\Form\MovieType;
use Offwhite\RaviewBundle\Model\Tmdb;

class SearchController extends Controller
{
    /*
     * Render the search form
     * @param String $queryString : Populates the search form with the supplied query
     * @return search_form.html
     */
    public function renderFormAction($queryString = null)
    {

        $movie = new Movie();

        if (null !== $queryString){
            $movie->setTitle($queryString);
        }

        $form  = $this->createForm(new MovieType(), $movie);

        return $this->render('OffwhiteRaviewBundle:Search:search_form.html.twig', array('form' => $form->createView()));
    }

    /*
     *  Processes the Search
     *  @required Search form in request with a valid title string
     *  @return Search_results.html.twig
     *  @throw \Exception
     */

    public function searchAction()
    {

        $request = $this->get('request_stack')->getCurrentRequest();

        $movie = new Movie();

        $form  = $this->createForm(new MovieType(), $movie);

        $form->bind($request);

        /*
         * redirect if request method is not POST
         */
        if ($request->getMethod() != 'POST') {
            return $this->redirect($this->generateUrl('offwhite_raview_homepage'));
        }

        /*
         * Check the Database
         */
        if (!$form->isValid()) {

            throw $this->createNotFoundException("I smell something fishy, and I'm not talking about the contents of Baldrick's apple crumble.");

        }else{

            /*
             * We don't know what TMDB records we don't have yet
             * So each search needs to query the TMDB API and be parsed by the TMDB service
             */

            $queryString = $form->getData()->getTitle();

            $tmdb = $this->get('offwhite.tmdb');

            $results = $tmdb->searchByTitle($queryString);

            /*
             * render results, include the query string in the template render
             */
            return $this->render('OffwhiteRaviewBundle:Search:search_results.html.twig', array(
                'results' => $results,
                'queryString' => $queryString
            ));

        }
    }
}
