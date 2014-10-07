<?php

namespace Hangman\CoreBundle\Event;

use Hangman\CoreBundle\Entity\Guess;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class GuessEvent
 *
 * @package Hangman\CoreBundle\Event
 */
class GuessEvent extends Event
{
    const CREATE_EVENT = 'guess.event.create';

    /**
     * @var Guess
     */
    protected $guess;

    /**
     * @param Guess $guess
     */
    public function __construct(Guess $guess)
    {
        $this->guess = $guess;
    }

    /**
     * @return Guess
     */
    public function getGuess()
    {
        return $this->guess;
    }
} 