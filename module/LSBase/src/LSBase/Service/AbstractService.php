<?php

namespace LSBase\Service;

use Doctrine\ORM\EntityManager;
use Zend\Stdlib\Hydrator;

/**
 * AbstractService
 *
 * Classe abstrata insert, update, delete
 *
 * @package LSBase\Service
 * @author Jesus Vieira <jesusvieiradelima@gmail.com>
 * @version  v1.0
 */
abstract class AbstractService
{

  /**
   * @var EntityManager
   */
  protected $em;
  protected $entity;

  public function __construct(EntityManager $em)
  {
    $this->em = $em;
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

    $entity = new $this->entity($data);
    $this->em->persist($entity);
    $this->em->flush();

    return $entity;
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
    $entity = $this->em->getReference($this->entity, $data['id']);

    $hydrator = new Hydrator\ClassMethods();
    $hydrator->hydrate($data, $entity);

    $this->em->persist($entity);
    $this->em->flush();

    return $entity;
  }

  /**
   * delete
   *
   * Deleta um registro
   *
   * @author Jesus Vieira <jesusvieiradelima@gmail.com>
   * @param integer $id
   * @access public
   * @return $entity
   */
  public function delete($id)
  {

    $entity = $this->em->getRepository($this->entity)->findOneBy(array('id' => $id));

    if ($entity) {
      $this->em->remove($entity);
      $this->em->flush();

      return $entity;
    }
  }

}
