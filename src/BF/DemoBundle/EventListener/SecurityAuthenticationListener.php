<?php
namespace BF\DemoBundle\EventListener;

class SecurityAuthenticationListener
{
    protected $Notifier;

    public function __construct($Notifier)
    {
        $this->Notifier = $Notifier;
    }

    public function onSecurityAuthenticationSuccess($event)
    {
        $username = $event->getAuthenticationToken()->getUser()->getUsername();

        $this->Notifier->verifierMessage($username);
    }
}