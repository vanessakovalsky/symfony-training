<?php
namespace App\EventListener;
use App\Event\LogEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LogListener{

    private $logger;

    public function __construct(LoggerInterface $logger){
        $this->logger = $logger;
    }

    public function onAppLogevent($logevent){
        $this->logger->info($logevent->getMessage());
    }
}
