<?php

namespace Offwhite\RaviewBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * MovieRepository
 *
 */
class MovieRepository extends EntityRepository
{
    public function searchByTitle($queryString = null, $limit = 10)
    {

        if (true === is_null($queryString)) {
            return false;
        }

        /*
         * Build query
         */
        $qb = $this->createQueryBuilder('m');

        $qb->select('m')
            ->where('m.title like :queryString')
            ->addOrderBy('m.title')
            ->setParameter('queryString', '%'.$queryString.'%');

        if (false === is_null($limit)) {
            $qb->setMaxResults($limit);
        }

        return $qb->getQuery()
            ->getResult();
    }

    /**
     * @param $imdbId
     * @return null|object
     */
    public function loadByImdbId($imdbId)
    {
        return $this->findOneBy(array('imdbId' => $imdbId));
    }

    /**
     * load a random movie from the latest 100 rows added
     *
     * @return \Movie || false
     */
    public function loadRandomMovie()
    {

        $latest = $this->createQueryBuilder('m')
            ->select('m')
            ->addOrderBy('m.id', 'DESC')
            ->setMaxResults(300)
            ->getQuery()
            ->getResult();

        if (!shuffle($latest) || count($latest) < 1) {
            return false;
        }

        return $latest[0];
    }
}
