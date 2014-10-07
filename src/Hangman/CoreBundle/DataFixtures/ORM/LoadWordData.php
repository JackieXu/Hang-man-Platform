<?php

namespace Hangman\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Hangman\CoreBundle\Entity\Word;

/**
 * Class LoadWordData
 *
 * @package Hangman\CoreBundle\DataFixtures\ORM
 */
class LoadWordData extends AbstractFixture
{
    /**
     * Load word data
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // Create new word
        $word = new Word();
        $word->setText('applepie');

        // Save to database
        $manager->persist($word);
        $manager->flush();

        // Add reference for later
        $this->addReference('word', $word);
    }
} 