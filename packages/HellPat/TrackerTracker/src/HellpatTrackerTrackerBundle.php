<?php


namespace HellPat\TrackerTracker;


use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class HellpatTrackerTrackerBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $logger = $container
            ->register(LogViolationLogger::class)->setAutowired(true);

        $subscriber = new Definition(ContentSecurityEventSubscriber::class);
        $subscriber->addTag('kernel.event_subscriber');
        $subscriber->addArgument($logger);

        $container->setDefinition(ContentSecurityEventSubscriber::class, $subscriber);
    }
}