<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloWolrdController
{
    /**
     * @Route ("hello")
     */
    public function helloWorldController(Request $request): Response
    {
        return new JsonResponse(['message' => 'Hello World']);
    }
}