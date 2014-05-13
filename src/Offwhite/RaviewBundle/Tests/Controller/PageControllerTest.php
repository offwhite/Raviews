<?php

namespace Offwhite\RaviewsBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomepageControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(1, $crawler->filter('h1:contains("Random Reviews")')->count());

        // get the random movie details
        $movieLink   = $crawler->filter('.homeRow a.title')->first();
        $crawler    = $client->click($movieLink->link());

        // Check the movieRow element is present
        $this->assertTrue($crawler->filter('article.movieRow')->count() > 0);
    }
}