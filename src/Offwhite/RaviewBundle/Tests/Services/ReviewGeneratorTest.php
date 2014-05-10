<?php

namespace Offwhite\RaviewBundle\Tests\Model;

require_once dirname(__DIR__).'/../../../../app/AppKernel.php';

use Offwhite\RaviewBundle\Entity\Movie;


class ReviewGeneratorTest extends \PHPUnit_Framework_TestCase
{

    /*
     * Thanks to Jakzal for the kernel aware test setup:
     * https://gist.github.com/jakzal/1319290
     *
     */

    protected $kernel;
    protected $container;
    protected $reviewGenerator;

    /**
     * @return null
     */
    public function setUp()
    {
        $this->kernel = new \AppKernel('test', true);
        $this->kernel->boot();

        $this->container = $this->kernel->getContainer();
        $this->entityManager = $this->container->get('doctrine')->getManager();

        $this->reviewGenerator = $this->container->get('offwhite.reviewGenerator');

        parent::setUp();
    }

    /**
     * @return null
     */
    public function tearDown()
    {
        $this->kernel->shutdown();

        parent::tearDown();
    }

    /*
     *  ======= END OF SETUP =======
     */

    /**
     * @return array
     */
    private function getPlaceholderArray()
     {
         // create a relection of reviewGenerator
         $reflection = new \ReflectionClass(get_class($this->reviewGenerator));

         // make availablePlaceholders accessible
         $property = $reflection->getProperty('availablePlaceholders');
         $property->setAccessible(true);
         $reviewGenerator = $this->reviewGenerator;

         // fetch availablePlaceholders
         return $property->getValue($reviewGenerator);
     }

    /**
     * Test reviewGenerator is in expected state after construct
     */
    public function testReviewGeneratorPlaceholders()
    {

        // fetch availablePlaceholders
        $availablePlaceholders = $this->getPlaceholderArray();

        // assert availablePlaceholders is an array
        $this->assertTrue(is_array($availablePlaceholders));

        // assert availablePlaceholders are > 0
        $this->assertGreaterThan(0, count($availablePlaceholders));

        // assert foundations are present
        $this->assertArrayHasKey('foundations', $availablePlaceholders, "See reviewComponents/README.md");

    }

    /*
     * Test generated reviews
     */
     public function testReviewGeneration()
     {
        // create a movie
        $movie = new Movie();
        $movie->setTitle('Testing');
        $movie->setYear(2013);
        $movie->setRating(50);
        $movie->setDirector('Testing');
        $movie->setCast('Actor1 - Character1||Actor2 - Character2||Actor3 - Character3||Actor4 - Character4||Actor5 - Character5');
        $movie->setRuntime(120);

        // test each foundation
        $availablePlaceholders = $this->getPlaceholderArray();

        for( $i=0; $i < count($availablePlaceholders['foundations']); $i++)
        {
            // generate random Review
            $review = $this->reviewGenerator->generateReview($movie);

            // assert review is a string longer than 13 chars
            $this->assertGreaterThan(13, strlen($review));

            // assert placeholders have been processed
            $this->assertFalse(strrpos($review, '{'), 'Error with Foundation['.$i.']');
        }

     }

}