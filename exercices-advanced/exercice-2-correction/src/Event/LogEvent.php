<?php
namespace App\Event;
use Symfony\Contracts\EventDispatcher\Event;

class LogEvent extends Event{
  const NAME = 'app.logevent';
  private $message;

  public function __construct($message){
    $this->message = $message;
  }

  public function getMessage(){
    return $this->message;
  }
}
