<?php

namespace Hangman\CoreBundle\Service;


use Hangman\CoreBundle\Entity\Game;
use Monolog\Logger;

/**
 * Class GameListener
 *
 * Handles actions pertaining game events.
 *
 * @package Hangman\CoreBundle\Service
 * @see Hangman\CoreBundle\Event\GameEvent
 */
class GameListener
{
    /**
     * @param Game $game
     * @param Logger $logger
     */
    public function onGameCreation(Game $game, Logger $logger)
    {
        $logger->info(sprintf(
            '%s: Created game with id %d',
            date('Y-m-d h-i-s'), $game->getId()
        ));
    }

    /**
     * @param Game $game
     * @param Logger $logger
     */
    public function onGameGuess(Game $game, Logger $logger)
    {
        $logger->info(sprintf(
            '%s: Guessed '
        ));
    }

    /**
     * @param Game $game
     * @param Logger $logger
     */
    public function onGameFailure(Game $game, Logger $logger)
    {

    }
} 