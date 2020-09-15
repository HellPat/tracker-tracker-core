<?php


namespace App\Controller;


use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class TrackerDemo extends AbstractController
{
    /**
     * @Route("/demo", name="demo")
     */
    public function __invoke(UrlGeneratorInterface $urlGenerator, LoggerInterface $logger): Response
    {
        return $this->render('demo/tracker.html.twig');
    }
}