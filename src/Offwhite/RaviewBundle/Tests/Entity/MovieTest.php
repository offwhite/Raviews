<?php

namespace Offwhite\RaviewBundle\Tests\Entity;

use Offwhite\RaviewBundle\Entity\Movie;

class MovieTest extends \PHPUnit_Framework_TestCase
{
    /*
     * only things to test really are title / slug functions.
     */
    public function testGenerateSlug()
    {
        $movie = new Movie();

        $this->assertEquals('blade-runner', $movie->generateSlug('Blade Runner'));
        $this->assertEquals('blade-runner', $movie->generateSlug('% Blade Runner %$ £'));
        $this->assertEquals('jaws-3d', $movie->generateSlug('JAWS 3D   '));
    }

    public function testSetTitle()
    {
        $movie = new Movie();

        $movie->setTitle('Hello World');
        $this->assertEquals('hello-world', $movie->getSlug());
    }
}