<?php

namespace LSUser\Service;

use Doctrine\ORM\EntityManager;
use LSBase\Service\AbstractService;

/**
 * User
 *
 * Classe Service User
 *
 * @package LSUser\Service
 * @author Jesus Vieira <jesusvieiradelima@gmail.com>
 * @version  v1.0
 */
class User extends AbstractService
{

    public function __construct(EntityManager $em)
    {
        parent::__construct($em);
        $this->entity = 'LSUser\Entity\User';
    }

    /**
     * insert
     *
     * Insere um registro.
     *
     * @author Jesus Vieira <jesusvieiradelima@gmail.com>
     * @param array $data
     * @access public
     * @return $entity
     */
    public function insert(array $data)
    {

        $typeUser = $this->em->getReference('LSTypeuser\Entity\TypeUser', $data['TypeUse']);

        if (get_class($typeUser) == 'LSTypeuser\\Entity\\TypeUser') {
            $data['TypeUse'] = $typeUser;

            return parent::insert($data);
        } else {
            return false;
        }
    }

    /**
     * update
     *
     * Atualiza um registro
     *
     * @author Jesus Vieira <jesusvieiradelima@gmail.com>
     * @param array $data
     * @access public
     * @return $entity
     */
    public function update(array $data)
    {
        $typeUser = $this->em->getReference('LSTypeuser\Entity\TypeUser', $data['TypeUse']);

        if (get_class($typeUser) == 'LSTypeuser\\Entity\\TypeUser') {

            $data['TypeUse'] = $typeUser;
            parent::update($data);
        } else {
            return false;
        }
    }

}