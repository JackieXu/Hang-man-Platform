<?php


namespace Hangman\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Word
 *
 * @ORM\Entity(repositoryClass="Hangman\CoreBundle\Entity\Repository\WordRepository")
 * @ORM\Table(name="words", indexes={
 *  @ORM\Index(name="word_index", columns={"text"})
 * })
 *
 * @package Hangman\CoreBundle\Entity
 */
class Word
{
    /**
     * Primary word identifier
     *
     * An integer is used to facilitate relational mapping between games and words.
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var integer
     */
    protected $id;

    /**
     * Actual word
     *
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    protected $text;

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
     * Set text
     *
     * @param string $text
     * @return Word
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string 
     */
    public function getText()
    {
        return $this->text;
    }
}
