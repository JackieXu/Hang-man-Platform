<?php

namespace Hangman\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Game
 *
 * @ORM\Entity(repositoryClass="Hangman\CoreBundle\Entity\Repository\GameRepository")
 * @ORM\Table(name="games", indexes={
 *  @ORM\Index(name="id_status_guesses_index", columns={"id", "status"})
 * })
 *
 * @package Hangman\CoreBundle\Entity
 */
class Game
{
    /**
     * Primary game identifier
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var integer
     */
    protected $id;

    /**
     * Game status
     *
     * Can be either of the following:
     *
     * busy     Game is ongoing.
     * fail     Game has crossed maximum number of attempts.
     * success  Game has successfully completed.
     *
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    protected $status;

    /**
     * Word to guess
     *
     * @ORM\ManyToOne(targetEntity="Hangman\CoreBundle\Entity\Word", inversedBy="games")
     *
     * @var \Hangman\CoreBundle\Entity\Word
     */
    protected $word;

    /**
     * Guesses
     *
     * @ORM\OneToMany(targetEntity="Hangman\CoreBundle\Entity\Guess", mappedBy="game")
     *
     * @var \Hangman\CoreBundle\Entity\Guess[]
     */
    protected $guesses;

    /**
     * Game constructor
     *
     * Currently sets default status value.
     */
    public function __construct()
    {
        $this->status = 'busy';
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Game
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set word
     *
     * @param \Hangman\CoreBundle\Entity\Word $word
     * @return Game
     */
    public function setWord(\Hangman\CoreBundle\Entity\Word $word = null)
    {
        $this->word = $word;

        return $this;
    }

    /**
     * Get word
     *
     * @return \Hangman\CoreBundle\Entity\Word 
     */
    public function getWord()
    {
        return $this->word;
    }

    /**
     * Add guesses
     *
     * @param \Hangman\CoreBundle\Entity\Guess $guesses
     * @return Game
     */
    public function addGuess(\Hangman\CoreBundle\Entity\Guess $guesses)
    {
        $this->guesses[] = $guesses;

        return $this;
    }

    /**
     * Remove guesses
     *
     * @param \Hangman\CoreBundle\Entity\Guess $guesses
     */
    public function removeGuess(\Hangman\CoreBundle\Entity\Guess $guesses)
    {
        $this->guesses->removeElement($guesses);
    }

    /**
     * Get guesses
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGuesses()
    {
        return $this->guesses;
    }
}
