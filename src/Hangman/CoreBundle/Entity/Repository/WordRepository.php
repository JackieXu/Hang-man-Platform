<?php

namespace Hangman\CoreBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class WordRepository
 *
 * Handles all actions pertaining word retrieval.
 *
 * @package Hangman\CoreBundle\Entity\Repository
 */
class WordRepository extends EntityRepository
{
    /**
     * Find all words used in games
     *
     * @return array
     */
    public function findUsedWords()
    {
        return $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('game.word')
            ->from('Hangman\CoreBundle\Entity\Game', 'game')
            ->getQuery()
            ->getResult();
    }

    /**
     * Finds random word
     *
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findRandomWord()
    {
        // Get count
        $count = $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('COUNT(word.id)')
            ->from('Hangman\CoreBundle\Entity\Word', 'word')
            ->setMaxResults(1)
            ->getQuery()
            ->getSingleScalarResult();

        // Select random number
        $randomId = rand(0, $count);

        // Get record
        return $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('word')
            ->from('Hangman\CoreBundle\Entity\Word', 'word')
            ->where('word.id = :id')
            ->setParameter('id', $randomId)
            ->getQuery()
            ->getSingleResult();
    }
}
