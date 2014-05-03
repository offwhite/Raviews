<?php

namespace Offwhite\RaviewBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PreviewController extends Controller
{

    /**
     * preview display controller
     * Allows you to check that reviewComponents make sense when processed.
     *
     * @param $movieId
     * @param $foundationId
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function showAction($movieId, $foundationId)
    {
        /*
         * Try to load the movie from the database
         */
        $em = $this->getDoctrine()->getManager();
        $movie = $em->getRepository('OffwhiteRaviewBundle:Movie')->find($movieId);

        if (!$movie) {
            throw $this->createNotFoundException('Unable to find that movie. You probably made it up.');
        }

        // generate a review - force the foundation index
        $review = $this->get('offwhite.reviewGenerator')->generateReview($movie);

        $movie->setRaview($review);

        return $this->render('OffwhiteRaviewBundle:Movie:show.html.twig', array(
            'movie'=>$movie
        ));
    }
}
