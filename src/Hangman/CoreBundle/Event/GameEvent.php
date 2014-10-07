<?php

namespace Hangman\CoreBundle\Event;

use Hangman\CoreBundle\Entity\Game;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class GameEvent
 *
 * Is fired off every time an action pertaining a game is performed.
 *
 * @package Hangman\CoreBundle\Event
 */
class GameEvent extends Event
{
    /**
     * Identifiers used by listeners
     */
    const CREATE_EVENT = 'game.event.create';
    const FAIL_EVENT = 'game.event.fail';

    /**
     * Game associated with event
     *
     * @var Game
     */
    protected $game;

    /**
     * Game Event constructor
     *
     * Constructs the GameEvent object and sets the appropriate Game object.
     *
     * @param Game $game
     */
    public function __construct(Game $game)
    {
        $this->game = $game;
    }

    /**
     * Returns the associated game
     *
     * @return Game
     */
    public function getGame()
    {
        return $this->game;
    }
}