<?php

namespace Offwhite\RaviewBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MovieController extends Controller
{

    /*
     * movie display controller
     */
    public function showAction($id)
    {
        /*
         * Try to load the movie from the database
         */
        $em = $this->getDoctrine()->getManager();
        $movie = $em->getRepository('OffwhiteRaviewBundle:Movie')->find($id);

        if (!$movie) {
            // TODO: call themoviesdb API and try to fetch the movie
            throw $this->createNotFoundException('Unable to find that movie. You probably made it up.');
        }

        return $this->render('OffwhiteRaviewBundle:Movie:show.html.twig', array(
            'movie'=>$movie
        ));
    }
}
