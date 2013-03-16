<?php

namespace LSAuth\LSHelpers;

use Zend\View\Helper\AbstractHelper;
use Zend\Authentication\AuthenticationService,
    Zend\Authentication\Storage\Session as SessionStorage;

class UserIdentity extends AbstractHelper {

    protected $authService;

    public function getAuthService() {
        return $this->authService;
    }

    public function __invoke($namespace = null) {
        $sessionStorage = new SessionStorage($namespace);
        $this->authService = new AuthenticationService;
        $this->authService->setStorage($sessionStorage);

        if ($this->getAuthService()->hasIdentity()) {
            $user = $this->getAuthService()->getIdentity();
            return $user[0];
        }
        else{
            header('Location: http://'.$_SERVER['SERVER_NAME'].'/auth');
            exit();
        }
    }
}