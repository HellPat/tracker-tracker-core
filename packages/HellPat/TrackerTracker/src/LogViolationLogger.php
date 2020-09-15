<?php


namespace HellPat\TrackerTracker;


use Psr\Log\LoggerInterface;

final class LogViolationLogger implements ViolationLogger
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function log(string $violation)
    {
        return $this->logger->warning('Content Security Violation', json_decode($violation, true));
    }
}