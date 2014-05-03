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

    /*
     * Test the apiCall method - ensure our credentials are valid
     * and curl is installed and working
     */
    public function testTmdbService()
    {

        //$tmdb = new \ReflectionClass('Offwhite\RaviewBundle\Model\Tmdb');
        // or
        //$apiCall = new \ReflectionMethod('Offwhite\RaviewBundle\Model\Tmdb', 'apiCall');
        //$apiCall->setAccessible(true);

        //$apiResponse = $apiCall->invoke('testing', 5);


        //$tmdb = $this->container->get('offwhite.tmdb');
        //$apiResponse = $tmdb->apiCall(null, 'Blade Runner');

        $this->assertNotNull($apiResponse);
        $this->assertNotEmpty($apiResponse);
        $this->assertAttributeNotEmpty('results', $apiResponse);
    }
}