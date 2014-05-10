<?php

namespace Offwhite\RaviewBundle\Tests\Model;

require_once dirname(__DIR__).'/../../../../app/AppKernel.php';


class TmdbTest extends \PHPUnit_Framework_TestCase
{

    /*
     * Thanks to Jakzal for the kernel aware test setup:
     * https://gist.github.com/jakzal/1319290
     *
     */

    protected $kernel;
    protected $entityManager;
    protected $container;

    /**
     * @return null
     */
    public function setUp()
    {
        $this->kernel = new \AppKernel('test', true);
        $this->kernel->boot();

        $this->container = $this->kernel->getContainer();
        $this->entityManager = $this->container->get('doctrine')->getManager();

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
     * Test the ApiCall method - ensure our credentials are valid
     * and curl is installed and working
     */
    public function testTmdbApiCall()
    {
        $tmdb = $this->container->get('offwhite.tmdb');

        // ApiCall method is private - create reflection
        $reflection = new \ReflectionClass(get_class($tmdb));
        $method = $reflection->getMethod('apiCall');
        $method->setAccessible(true);

        // make an api request with the id 78 (blade runner)
        $apiResponse = $method->invokeArgs($tmdb, array(78));

        // assert the response was not null
        $this->assertNotNull($apiResponse);

        // assert the api response wasn't an error code
        $this->assertObjectNotHasAttribute('status_message', $apiResponse, 'TMDB API ERROR: Check your API key');

        // in case TMDB changes error responses, assert we have a title attribute
        $this->assertObjectHasAttribute('title', $apiResponse, 'TMDB API configuration error');

        // assert the title attribute is as expected
        $this->assertEquals('Blade Runner', $apiResponse->title);
    }

    /*
     * Test the Search method
     */
    public function testTmdbSearch()
    {

        $tmdb = $this->container->get('offwhite.tmdb');
        $searchResults = $tmdb->searchByTitle('Blade Runner');

        $this->assertNotNull($searchResults);
        //$this->assertNotEmpty($searchResults);
        $this->assertGreaterThan(0,count($searchResults));
    }

}