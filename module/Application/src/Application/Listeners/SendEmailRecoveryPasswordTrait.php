<?php

namespace Application\Listeners;

use Application\Mail\Mail;
use Zend\EventManager\EventInterface;

/**
 * Trait SendEmailRecoveryPasswordTrait
 *
 * @package Application\Listeners
 */
trait SendEmailRecoveryPasswordTrait
{
    public function sendEmail(EventInterface $event)
    {
        /**
         * @var $controller  \Zend\Mvc\Controller\AbstractActionController
         * @var $mailService \AcMailer\Service\MailService
         */
        $controller = $event->getTarget();
        $serviceManager = $controller->getServiceLocator();
        $mailService = $serviceManager->get('AcMailer\Service\MailService');
        $data = $event->getParam('data');

        //Dispatch email
        $mailService->setTemplate('mailer/recovery-password.phtml', $data);
        $mailService->setSubject('Recovery Password');
        $message = $mailService->getMessage();
        $message->addTo($data['email']);
        $mailService->send();
    }
}
