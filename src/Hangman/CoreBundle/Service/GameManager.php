<?php

namespace Hangman\CoreBundle\Service;

use Doctrine\ORM\EntityManager;
use Hangman\CoreBundle\Entity\Game;
use Hangman\CoreBundle\Entity\Word;
use Hangman\CoreBundle\Event\GameEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class GameManager
 *
 * Handles actions pertaining games.
 *
 * @package Hangman\CoreBundle\Service
 */
class GameManager
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
        $this->repository = $this->entityManager->getRepository('HangmanCoreBundle:Game');
    }

    /**
     * Creates a new game instance
     *
     * @return \Hangman\CoreBundle\Entity\Game
     */
    public function create()
    {
        // Get class
        $class = $this->class;

        // Create new instance
        $game = new $class();

        return $game;
    }

    /**
     * Creates a new game with a specific word
     *
     * @param Word $word
     * @return Game
     */
    public function createWithWord(Word $word)
    {
        // Create new game
        $game = $this->create();

        // Set word
        $game->setWord($word);

        // Save game
        return $this->save($game);
    }

    /**
     * Persists a game to the database
     *
     * @param Game $game
     * @return Game
     */
    public function persist(Game $game)
    {
        // Persist using entity manager
        $this->entityManager->persist($game);

        return $game;
    }

    /**
     * Saves a game onto the database
     *
     * Also handles sending a game creation event.
     *
     * @param Game $game
     * @return Game
     */
    public function save(Game $game)
    {
        // Persist game to database
        $this->persist($game);

        // Flush to save
        $this->entityManager->flush();

        // Dispatch new creation event
        $this->dispatcher->dispatch(GameEvent::CREATE_EVENT, new GameEvent($game));

        return $game;
    }

    /**
     * Returns the game repository
     *
     * @return \Hangman\CoreBundle\Entity\Repository\GameRepository
     */
    public function getRepository()
    {
        return $this->repository;
    }
} 