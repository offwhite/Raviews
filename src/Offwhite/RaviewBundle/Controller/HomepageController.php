<?php

namespace Offwhite\RaviewBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class HomepageController extends Controller
{
    public function indexAction()
    {

        $em = $this->getDoctrine()->getManager();

        $movie = $em->getRepository('OffwhiteRaviewBundle:Movie')
            ->loadRandomMovie();

        return $this->render('OffwhiteRaviewBundle:Homepage:index.html.twig', array(
            'randomMovie' => $movie
        ));
    }
}
