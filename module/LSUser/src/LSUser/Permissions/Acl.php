<?php

namespace LSUser\Permissions;

use Zend\Permissions\Acl\Acl as ClassAcl;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;

class Acl extends ClassAcl
{

    protected $roles;
    protected $resources;
    protected $privileges;

    public function __construct(array $roles, array $resources) {

        $this->roles = $roles;
        $this->resources = $resources;
        $this->privileges = array('edit', 'view', 'delete', 'relatory');

        $this->loadRoles();
        $this->loadResources();
        $this->loadPrivileges();
    }

    protected function loadRoles()
    {
        foreach($this->roles as $key => $role)
        {
            if( ($role[$key][0] != 1) && ($role[$key][1] != "Administrador")  )  {
                $this->addRole(new Role($role[$key][1]));
            }

            if ( ($role[$key][0] == 1) && ($role[$key][0] == "Administrador")  ){
                $this->allow($role[$key][1] ,array(),array());
            }

        }
    }

    protected function loadResources()
    {
        foreach($this->resources as $key => $resource)
        {
            $this->addResource(new Resource($resource[$key][1]));
        }
    }

    protected function loadPrivileges()
    {

        foreach($this->privileges as $privilege)
        {
            $this->allow($privilege->getRole()->getNome(), $privilege->getResource()->getNome(),$privilege->getNome());
        }
    }
}
