<?php


namespace Hangman\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Guess
 *
 * @ORM\Entity(repositoryClass="Hangman\CoreBundle\Entity\Repository\GuessRepository")
 * @ORM\Table(name="guesses", indexes={
 *  @ORM\Index(name="character_index", columns={"letter"})
 * })
 *
 * @package Hangman\CoreBundle\Entity
 */
class Guess
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Hangman\CoreBundle\Entity\Game", inversedBy="guesses")
     *
     * @var \Hangman\CoreBundle\Entity\Game
     */
    protected $game;

    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=1, options={"fixed" = true})
     *
     * @var string
     */
    protected $letter;

    /**
     * Set letter
     *
     * @param string $letter
     * @return Guess
     */
    public function setLetter($letter)
    {
        $this->letter = $letter;

        return $this;
    }

    /**
     * Get letter
     *
     * @return string 
     */
    public function getLetter()
    {
        return $this->letter;
    }

    /**
     * Set game
     *
     * @param \Hangman\CoreBundle\Entity\Game $game
     * @return Guess
     */
    public function setGame(\Hangman\CoreBundle\Entity\Game $game)
    {
        $this->game = $game;

        return $this;
    }

    /**
     * Get game
     *
     * @return \Hangman\CoreBundle\Entity\Game 
     */
    public function getGame()
    {
        return $this->game;
    }
}
