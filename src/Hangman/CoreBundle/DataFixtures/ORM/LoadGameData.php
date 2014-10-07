<?php

namespace Hangman\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Hangman\CoreBundle\Entity\Game;

/**
 * Class LoadGameData
 *
 * @package Hangman\CoreBundle\DataFixtures\ORM
 */
class LoadGameData extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * Load game data
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // Create new game
        $game = new Game();
        $game->setWord($this->getReference('word'));

        // Save game to database
        $manager->persist($game);
        $manager->flush();

        $this->setReference('game', $game);
    }

    /**
     * Get dependencies
     *
     * Games are dependent on words, and thus those should be
     * loaded first.
     *
     * @return array
     */
    public function getDependencies()
    {
        return array(
            'Hangman\CoreBundle\DataFixtures\ORM\LoadWordData'
        );
    }
} 