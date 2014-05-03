<?php

namespace Offwhite\RaviewBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Offwhite\RaviewBundle\Entity\Movie;

class MovieFixtures implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $movie_01 = new Movie();
        $movie_01->setTitle('Blade Runner');
        $movie_01->setYear(1982);
        $movie_01->setDirector('Ridley Scott');
        $movie_01->setRaview('Lorem ipsum dolor sit amet, consectetur adipiscing eletra electrify denim vel ports.\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi ut velocity magna. Etiam vehicula nunc non leo hendrerit commodo. Vestibulum vulputate mauris eget erat congue dapibus imperdiet justo scelerisque. Nulla consectetur tempus nisl vitae viverra. Cras el mauris eget erat congue dapibus imperdiet justo scelerisque. Nulla consectetur tempus nisl vitae viverra. Cras elementum molestie vestibulum. Morbi id quam nisl. Praesent hendrerit, orci sed elementum lobortis, justo mauris lacinia libero, non facilisis purus ipsum non mi. Aliquam sollicitudin, augue id vestibulum iaculis, sem lectus convallis nunc, vel scelerisque lorem tortor ac nunc. Donec pharetra eleifend enim vel porta.');
        $movie_01->setRating(75);
        $movie_01->setRuntime('120');
        $movie_01->setTagLine('More Human than Human');
        $movie_01->setOverview('In 2019, humans have genetically engineered Replicants, which are essentially humans who are designed for labor and entertainment purposes. They are illegal on earth, and if they make it to our planet they are hunted down and killed. Rick Deckard is a blade runner, a hunter of replicants. A group of replicants makes it to Los Angeles seeking a way to extend their life span. Replicants have a built-in 4 year life span, and this group is near the end.');
        $movie_01->setImdbId('tt0083658');
        $movie_01->setImagePoster('/p64TtbZGCElxQHpAMWmDHkWJlH2.jpg');
        $movie_01->setImageBackground('/yNlVk0HnxvY5Z1raID9N6SKeFid.jpg');
        $movie_01->setCast('Harrison Ford - Rick Deckard||Rutger Hauer - Roy Batty||Sean Young - Rachael||Edward James Olmos - Gaff||M. Emmet Walsh - Bryant||Daryl Hannah - Pris||William Sanderson - J.F. Sebastian||Brion James - Leon Kowalski||Joe Turkel - Eldon Tyrell');
        $movie_01->setCreated(new \DateTime());
        $manager->persist($movie_01);

        $movie_02 = new Movie();
        $movie_02->setTitle('Blade');
        $movie_02->setYear(1998);
        $movie_02->setDirector('Stephen Norrington');
        $movie_02->setRaview('Lipsum dolor sit amet, consectetur adipiscing eletra electrify denim vel ports.\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi ut velocity magna. Etiam vehicula nunc non leo hendrerit commodo. Vestibulum vulputate mauris eget erat congue dapibus imperdiet justo scelerisque. Nulla consectetur tempus nisl vitae viverra. Cras el mauris eget erat congue dapibus imperdiet justo scelerisque. Nulla consectetur tempus nisl vitae viverra. Cras elementum molestie vestibulum. Morbi id quam nisl. Praesent hendrerit, orci sed elementum lobortis, justo mauris lacinia libero, non facilisis purus ipsum non mi. Aliquam sollicitudin, augue id vestibulum iaculis, sem lectus convallis nunc, vel scelerisque lorem tortor ac nunc. Donec pharetra eleifend enim vel porta.');
        $movie_02->setRating(67);
        $movie_02->setRuntime('120');
        $movie_02->setTagLine('Part Man. Part Vampire. All Hero.');
        $movie_02->setOverview('When Blade\'s mother was bitten by a vampire during pregnancy, she did not know that she gave her son a special gift while dying: All the good vampire attributes in combination with the best human skills. Blade and his mentor Whistler battle an evil vampir');
        $movie_02->setImdbId('tt0120611');
        $movie_02->setImagePoster('/kR3DscGbvJ5NnYhTOuMAlmEtYYD.jpg');
        $movie_02->setCast('Wesley Snipes - Blade||Stephen Dorff - Deacon Frost||Kris Kristofferson - Whistler||N\'Bushe Wright - Karen||Donal Logue - Quinn||Udo Kier - Dragonetti||Arly Jover - Mercury||Traci Lords - Racquel||Kevin Patrick Walls - Krieger||Tim Guinee - Curtis Webb');
        $movie_02->setCreated(new \DateTime());
        $manager->persist($movie_02);

        $manager->flush();
    }

}