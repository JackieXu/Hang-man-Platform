<?php

namespace Hangman\CoreBundle\Service;
use Doctrine\ORM\EntityManager;
use Hangman\CoreBundle\Entity\Game;
use Hangman\CoreBundle\Entity\Word;
use Hangman\CoreBundle\Event\GameEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class WordManager
 *
 * Handles actions pertaining words.
 *
 * @package Hangman\CoreBundle\Service
 */
class WordManager
{
    /**
     * Word class name
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
     * @var \Hangman\CoreBundle\Entity\Repository\WordRepository
     */
    protected $repository;

    /**
     * Word Manager constructor
     *
     * @param string $class
     * @param EventDispatcherInterface $dispatcher
     * @param EntityManager $entityManager
     */
    public function __construct($class, EventDispatcherInterface $dispatcher, EntityManager $entityManager)
    {
        $this->class = $class;
        $this->dispatcher = $dispatcher;
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository('HangmanCoreBundle:Word');
    }

    /**
     * Creates a new word instance
     *
     * @return \Hangman\CoreBundle\Entity\Word
     */
    public function create()
    {
        // Get class
        $class = $this->class;

        // Create new instance
        $word = new $class();

        return $word;
    }

    /**
     * Persists a word to the database
     *
     * @param Word $word
     * @return Word
     */
    public function persist(Word $word)
    {
        // Persist using entity manager
        $this->entityManager->persist($word);

        return $word;
    }

    /**
     * Saves a word onto the database
     *
     * Also handles sending a word creation event.
     *
     * @param Word $word
     * @return Word
     */
    public function save(Word $word)
    {
        // Persist game to database
        $this->persist($word);

        // Flush to save
        $this->entityManager->flush();

        /**
         * Yeah... I think this would be overkill, don't you think?
        $this->dispatcher->dispatch(WordEvent::CREATE_EVENT, new WordEvent($word));
         */

        return $word;
    }

    /**
     * Returns the word repository
     *
     * @return \Hangman\CoreBundle\Entity\Repository\WordRepository
     */
    public function getRepository()
    {
        return $this->repository;
    }
} 