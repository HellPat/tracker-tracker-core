<?php


namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Probe
{
    /**
     * @Route("/probe.js", name="probe")
     */
    public function __invoke(): Response
    {
        $response = new Response(<<<SCRIPT

        SCRIPT);

        $response->headers->set('Content-Type', 'application/javascript');
        $response->setPrivate();

        return $response;
    }
}