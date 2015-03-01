<?php

namespace Application\Listeners;

use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\Mvc\MvcEvent;
use Application\Listeners\SendEmailRecoveryPasswordTrait;
use Application\Listeners\ZfcUserTrait;
use Application\Listeners\ContentHeaderTrait;

/**
 * Class ControllerListener
 *
 * @package Application\Listeners
 */
class ControllerListener extends AbstractListenerAggregate
{
    use SendEmailRecoveryPasswordTrait;
    use ZfcUserTrait;
    use ContentHeaderTrait;

    /**
     * {@inheritdoc}
     */
    public function attach(EventManagerInterface $events)
    {
        $sharedEvents = $events->getSharedManager();

        $this->listeners[] = $sharedEvents->attach(
            'Application\Controller\CategoryController',
            MvcEvent::EVENT_DISPATCH,
            [$this, 'category'],
            99
        );

        $this->listeners[] = $sharedEvents->attach(
            'Application\Controller\UserController',
            'sendEmail.pre',
            [$this, 'sendEmail'],
            20
        );

        //listener for ZfcUser, edit template login
        $this->listeners[] = $sharedEvents->attach(
            'ZfcUser\Controller\UserController',
            MvcEvent::EVENT_DISPATCH,
            [$this, 'zfcUser'],
            -99
        );
    }
}
