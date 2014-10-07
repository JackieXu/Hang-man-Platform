<?php

namespace Hangman\CoreBundle\Service;

use Doctrine\ORM\EntityManager;
use Hangman\CoreBundle\Entity\Game;
use Hangman\CoreBundle\Entity\Guess;
use Hangman\CoreBundle\Event\GuessEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class GameManager
 *
 * Handles actions pertaining games.
 *
 * @package Hangman\CoreBundle\Service
 */
class GuessManager
{
    /**
     * Game class name
     *
     * @var string
     */
    protected $class;

    /**
     * Symfony event dispatcher service
     *
     * @var \Symfony\Component\EventDispatcher\EventDispatcherInterface
     */
    protected $dispatcher;

    /**
     * Doctrine entity manager
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    /**
     * @var \Hangman\CoreBundle\Entity\Repository\GameRepository
     */
    protected $repository;

    /**
     * Game Manager constructor
     *
     * Construction is handled via the Symfony services file.
     *
     * @param string $class
     * @param EventDispatcherInterface $dispatcher
     * @param EntityManager $entityManager
     * @see Hangman\CoreBundle\Resources\config\services.yml
     */
    public function __construct($class, EventDispatcherInterface $dispatcher, EntityManager $entityManager)
    {
        $this->class = $class;
        $this->dispatcher = $dispatcher;
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository('HangmanCoreBundle:Guess');
    }

    /**
     * Creates a new guess instance
     *
     * @return \Hangman\CoreBundle\Entity\Guess
     */
    public function create()
    {
        // Get class
        $class = $this->class;

        // Create new instance
        $instance = new $class();

        return $instance;
    }

    /**
     * Creates and saves a new guess with given game and letter
     *
     * @param Game $game
     * @param string $letter
     * @return Guess
     */
    public function createWithGameAndLetter(Game $game, $letter)
    {
        // Create new guess instance
        $guess = $this->create();

        // Set guess attributes
        $guess->setGame($game);
        $guess->setLetter($letter);

        // Save guess and return
        return $this->save($guess);
    }

    /**
     * Persists a guess to the database
     *
     * @param Guess $guess
     * @return Guess
     */
    public function persist(Guess $guess)
    {
        // Persist using entity manager
        $this->entityManager->persist($guess);

        return $guess;
    }

    /**
     * Saves a game onto the database
     *
     * Also handles sending a game creation event.
     *
     * @param Guess $guess
     * @return Guess
     */
    public function save(Guess $guess)
    {
        // Persist game to database
        $this->persist($guess);

        // Flush to save
        $this->entityManager->flush();

        // Dispatch new creation event
        $this->dispatcher->dispatch(GuessEvent::CREATE_EVENT, new GuessEvent($guess));

        return $guess;
    }

    /**
     * Returns the game repository
     *
     * @return \Hangman\CoreBundle\Entity\Repository\GuessRepository
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * Checks letter validity
     *
     * @param string $letter
     * @return bool
     */
    public function isValidLetter($letter)
    {
        return 1 === strlen($letter) && ctype_lower($letter);
    }
} 