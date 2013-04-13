<?php
namespace BF\DemoBundle\EventListener;

use BF13\Component\Notification\Notification;
class SecurityAuthenticationListener
{
    protected $Notifier;

    public function __construct(Notification $Notifier)
    {
        $this->Notifier = $Notifier;
    }

    public function onSecurityAuthenticationSuccess($event)
    {
        $username = $event->getAuthenticationToken()->getUser()->getUsername();

        $this->Notifier->checkNewMessage($username);
    }
}