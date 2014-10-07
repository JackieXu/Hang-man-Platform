<?php

namespace Hangman\CoreBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Hangman\CoreBundle\Entity\Game;

/**
 * Class GuessRepository
 *
 * Handles all actions pertaining guess retrieval.
 *
 * @package Hangman\CoreBundle\Entity\Repository
 */
class GuessRepository extends EntityRepository
{
    /**
     * Find guess by game and letter
     *
     * @param Game $game
     * @param string $letter
     * @return \Hangman\CoreBundle\Entity\Guess
     */
    public function findGuessByGameAndLetter(Game $game, $letter)
    {
        return $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('guess')
            ->from('Hangman\CoreBundle\Entity\Guess', 'guess')
            ->where('guess.game = :game')
            ->andWHere('guess.letter = :letter')
            ->setParameter('game', $game)
            ->setParameter('letter', $letter)
            ->getQuery()
            ->getResult();
    }

    /**
     * Finds correct guesses in a game
     *
     * @param Game $game
     * @return \Hangman\CoreBundle\Entity\Guess
     */
    public function findCorrectGuesses(Game $game)
    {
        // Create query builder
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();

        return $queryBuilder
            ->select('guess')
            ->from('Hangman\CoreBundle\Enttiy\Guess', 'guess')
            ->leftJoin('Hangman\CoreBundle\Entity\Game', 'game', 'game = guess.game')
            ->leftJoin('Hangman\CoreBundle\Entity\Word', 'word', 'game.word = word')
            ->where($queryBuilder->expr()->like('guess.letter', '%word.text%'))
            ->getQuery()
            ->getResult();
    }
}
