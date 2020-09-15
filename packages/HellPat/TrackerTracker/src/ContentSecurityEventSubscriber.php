<?php


namespace HellPat\TrackerTracker;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class ContentSecurityEventSubscriber implements EventSubscriberInterface
{
    public const REPORT_URI = '/report_violation';

    private ViolationLogger $logger;
    private string $reportUri;

    public function __construct(ViolationLogger $logger, string $reportUri = self::REPORT_URI)
    {
        $this->logger = $logger;
        $this->reportUri = $reportUri;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::RESPONSE => 'contentSecurityHeader',
            KernelEvents::REQUEST => ['recordViolation', 999],
        ];
    }

    public function recordViolation(RequestEvent $event): void
    {
        $request = $event->getRequest();

        if (! $event->isMasterRequest()) {
            return;
        }

        if ($request->getMethod() !== Request::METHOD_POST){
            return;
        }

        if ($request->getRequestUri() !== $this->reportUri) {
            return;
        }

        $this->logger->log($request->getContent());

        $event->setResponse(new Response(null, Response::HTTP_NO_CONTENT));
        $event->stopPropagation();
    }

    public function contentSecurityHeader(ResponseEvent $event): void
    {
        $response = $event->getResponse();
        $response->headers->set(
            'Content-Security-Policy-Report-Only',
            sprintf('default-src self; report-uri %s', $this->reportUri)
        );

        $event->setResponse($response);
    }
}