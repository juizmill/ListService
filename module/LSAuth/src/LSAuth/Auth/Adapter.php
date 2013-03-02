<?php

namespace LSAuth\Auth;

use Zend\Authentication\Adapter\AdapterInterface,
    Zend\Authentication\Result;

use Doctrine\ORM\EntityManager;

class Adapter implements AdapterInterface {

    /**
     *
     * @var EntityManager
     */
    protected $em;
    protected $login;
    protected $password;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    public function getLogin() {
        return $this->login;
    }

    public function setlogin($login) {
        $this->login = $login;
        return $this;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
        return $this;
    }


    public function authenticate() {
        $repository = $this->em->getRepository('LSUser\Entity\User');

        $user = $repository->findByLoginAndPassword($this->getLogin(), $this->getPassword());

        if($user){
            return new Result(Result::SUCCESS, array('user' => $user), array('OK'));
        }else{
            return new Result(Result::FAILURE_CREDENTIAL_INVALID, null, array());
        }

    }

}