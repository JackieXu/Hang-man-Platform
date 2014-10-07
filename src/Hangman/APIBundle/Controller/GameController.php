<?php

namespace Hangman\APIBundle\Controller;

use Doctrine\Common\Util\Debug;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class GameController
 *
 * Simple Hangman game API
 *
 * @package Hangman\APIBundle\Controller
 */
class GameController extends APIController
{
    /**
     * Creates new game
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function createAction(Request $request)
    {
        // Get appropriate managers
        $wordManager = $this->get('hangman_core.manager.word');
        $gameManager = $this->get('hangman_core.manager.game');

        // Get random word
        $word = $wordManager->getRepository()->findRandomWord();

        // Create new game
        $game = $gameManager->createWithWord($word);

        return new JsonResponse(array(
            'type' => 'success',
            'game' => $game->getId()
        ));
    }

    /**
     * Submits a guess to a game
     *
     * @param string $id
     * @param Request $request
     * @return JsonResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function guessAction($id, Request $request)
    {
        // Get appropriate managers
        $gameManager = $this->get('hangman_core.manager.game');
        $guessManager = $this->get('hangman_core.manager.guess');

        // Get game via id, and check for activity
        $game = $gameManager->getRepository()->findActiveGameById($id);

        // In case a game wasn't found (or found to be invalid), return error response
        if (!$game) {
            return $this->createErrorResponse('Invalid game');
        }

        // Get letter, the default value is to assist with additional string functions
        $letter = strtolower(trim($request->request->get('c', '')));

        // Check for empty and non-alphabetic strings
        if (!$guessManager->isValidLetter($letter)) {
            return $this->createErrorResponse('Invalid letter');
        }

        // Check if current guess was already made
        $guess = $guessManager->getRepository()->findGuessByGameAndLetter($game, $letter);

        // In case of previously made guess, send error response
        if ($guess) {
            return $this->createErrorResponse('Letter already guessed');
        }

        // Create new guess using given letter on game with id
        $guessManager->createWithGameAndLetter($game, $letter);

        return $this->redirect($this->generateUrl('hangman_game_detailed', array(
            'id' => $id
        )));
    }

    /**
     * Returns a list of active games
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function listAction(Request $request)
    {
        // Get game manager
        $gameManager = $this->get('hangman_core.manager.game');

        // Get list of active games
        $games = $this->transformGames($gameManager->getRepository()->findActiveGames());

        return new JsonResponse(array(
            'type' => 'success',
            'games' => $games
        ));
    }

    /**
     * Returns a detailed overview of a game
     *
     * @param string $id
     * @param Request $request
     * @return JsonResponse
     */
    public function detailedAction($id, Request $request)
    {
        // Get game manager
        $gameManager = $this->get('hangman_core.manager.game');

        // Find game
        $game = $gameManager->getRepository()->findActiveGameById($id);

        // If no active game was found, return an error response
        if (!$game) {
            return $this->createErrorResponse('Invalid game');
        }

        // Get game overview
        $gameOverview = $this->getGameOverview($game);

        return new JsonResponse(array(
            'type' => 'success',
            'game' => $gameOverview
        ));
    }

    /**
     * Transforms array of game entities into usable API form
     *
     * @param \Hangman\CoreBundle\Entity\Game[] $games
     * @return array
     */
    protected function transformGames($games)
    {
        return array_map(function ($game) {
            return array(
                'id' => $game->getId(),
                'guesses' => array_map(function ($guess) {
                    return $guess->getLetter();
                }, $game->getGuesses()->toArray())
            );
        }, $games);
    }

    /**
     * Returns an API usable overview of a game
     *
     * @param \Hangman\CoreBundle\Entity\Game $game
     * @return array
     */
    protected function getGameOverview($game)
    {
        // Amount of failed guess attempts
        $failedAttempts = 0;

        // Array holding parts of the word that are already guessed
        $guessedWord = array_fill(0, strlen($game->getWord()->getText()), '.');

        // Get all letters in word
        $letters = str_split($game->getWord()->getText());

        // Limited some variables to a for-loop's scope
        foreach ($game->getGuesses() as $guess) {
            if (in_array($guess->getLetter(), $letters)) {
                $charOffset = 0;

                while (($charOffset = strpos($game->getWord()->getText(), $guess->getLetter(), $charOffset)) !== false) {
                    $guessedWord[$charOffset] = $guess->getLetter();
                    $charOffset++;
                }
            } else {
                $failedAttempts++;
            }
        }

        return array(
            'id' => $game->getId(),
            'status' => $game->getStatus(),
            'tries_left' => 11 - $failedAttempts,
            'word' => join('', $guessedWord)
        );
    }
}
