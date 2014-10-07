<?php


namespace Hangman\APIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class APIController
 *
 * Simple API controller adding utility methods.
 *
 * @package Hangman\APIBundle\Controller
 */
class APIController extends Controller
{
    /**
     * Creates an error response
     *
     * @param string $string
     * @return JsonResponse
     */
    protected function createErrorResponse($string)
    {
        return new JsonResponse(array(
            'type' => 'error',
            'message' => $string
        ));
    }
} 