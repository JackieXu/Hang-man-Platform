<?php

namespace Hangman\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class GameController
 *
 * Handles calls made to the web interface of the Hang, man! platform.
 *
 * @package Hangman\WebBundle\Controller
 */
class GameController extends Controller
{
    /**
     * Displays list view of active games
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        // Get game manager
        $gameManager = $this->get('hangman_core.manager.game');

        // Get list of active games
        $games = $gameManager->getRepository()->findActiveGames();

        return $this->render('HangmanWebBundle:Game:index.html.twig', array(
            'games' => $games
        ));
    }

    /**
     * Displays detailed view of a game
     *
     * @param integer $id
     * @return \Symfony\Component\HttpFoundation\Response|\Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function detailedAction($id)
    {
        // Get game manager
        $gameManager = $this->get('hangman_core.manager.game');

        // Find game
        $game = $gameManager->getRepository()->findActiveGameById($id);

        // Throw error if not found
        if (!$game) {
            return $this->createNotFoundException('Invalid game');
        }

        return $this->render('HangmanWebBundle:Game:detailed.html.twig', array(
            'game' => $game
        ));
    }
} 