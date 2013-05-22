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
    protected $newRoles;
    protected $newResoirces;
    protected $newprivileges;

    public function __construct(array $roles, array $resources, array $privileges) {

        $this->roles = $roles;
        $this->resources = $resources;
        $this->privileges = $privileges;

        $this->loadRoles();
        $this->loadResources();
        $this->loadPrivileges();
    }

    protected function loadRoles()
    {
        foreach($this->roles as $role)
        {

            $this->addRole(new Role($role['description']));

            if ( ($role['id'] == 1) && ($role['description'] == "adm")  ){
                $this->allow($role['description'] ,array(),array());
            }

            $this->newRoles[] = $role['description'];
        }
    }

    protected function loadResources()
    {
        foreach($this->resources as $resource)
        {
            $this->addResource(new Resource($resource['description']));

            $this->newResoirces[] = $resource['description'];
        }
    }

    protected function loadPrivileges()
    {

        foreach($this->privileges as $privilege)
            $permissions[] = $privilege['permissions'];

        foreach($this->privileges as $privilege)
        {
            $this->allow($privilege['roles'], $this->newResoirces, $permissions);
        }
    }
}
