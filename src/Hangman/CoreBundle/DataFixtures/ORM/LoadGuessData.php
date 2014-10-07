<?php

namespace Hangman\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Hangman\CoreBundle\Entity\Guess;

/**
 * Class LoadGuessData
 *
 * @package Hangman\CoreBundle\DataFixtures\ORM
 */
class LoadGuessData extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * Load guess data
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // Create new guess
        $guess = new Guess();
        $guess->setLetter('a');
        $guess->setGame($this->getReference('game'));

        // Save to database
        $manager->persist($guess);
        $manager->flush();
    }

    /**
     * Get dependencies
     *
     * Guesses are dependent on existing games, and thus those should be
     * loaded first.
     *
     * @return array
     */
    public function getDependencies()
    {
        return array(
            'Hangman\CoreBundle\DataFixtures\ORM\LoadGameData'
        );
    }
} 