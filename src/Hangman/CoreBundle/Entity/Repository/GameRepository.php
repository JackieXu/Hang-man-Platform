<?php

namespace Hangman\CoreBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class GameRepository
 *
 * Handles all actions pertaining game retrieval.
 *
 * @package Hangman\CoreBundle\Entity\Repository
 */
class GameRepository extends EntityRepository
{
    /**
     * Finds all active games
     *
     * @return \Hangman\CoreBundle\Entity\Game[]
     */
    public function findActiveGames()
    {
        return $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('game')
            ->from('Hangman\CoreBundle\Entity\Game', 'game')
            ->where('game.status = \'busy\'')
            ->getQuery()
            ->getResult();
    }

    /**
     * Finds an active game with given id
     *
     * @param integer $id
     * @return \Hangman\CoreBundle\Entity\Game
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findActiveGameById($id)
    {
        return $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('game')
            ->from('Hangman\CoreBundle\Entity\Game', 'game')
            ->where('game.id = :id')
            ->andWhere('game.status = \'busy\'')
            ->setParameter('id', $id)
            ->getQuery()
            ->getSingleResult();
    }
}
