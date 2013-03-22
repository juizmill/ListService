<?php
namespace LSTicket\Service;

use Doctrine\ORM\EntityManager;

use LSBase\Service\AbstractService;
use LSInteraction\Entity\Interaction;

/**
 * Ticket
 *
 * Classe Service Ticket
 *
 * @package LSTicket\Service
 * @author Jesus Vieira <jesusvieiradelima@gmail.com>
 * @version  v1.0
 */
class Ticket extends AbstractService
{
  public function __construct(EntityManager $em)
  {
    parent::__construct($em);
    $this->entity = 'LSTicket\Entity\Ticket';
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
        $categoryTicket = $this->em->getReference('LSCategoryticket\Entity\CategoryTicket', $data['categoryTicket']);

        if (get_class($categoryTicket) == 'LSCategoryticket\\Entity\\CategoryTicket') {

            $data['categoryTicket'] = $categoryTicket;

            return parent::insert($data);

        } else {
            return false;
        }
    }




    #REMOVER O UPDATE NÃO TERÁ COMO ALTERAR O TICKET DEPOIS DE CADASTRADO.

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

        $category = $this->em->getReference('LSCategoryticket\Entity\CategoryTicket', $data['categoryTicket']);

        //\Zend\Debug\Debug::dump($category);die;

        if ($category) {

            $data['categoryTicket'] = $category;
            return parent::update($data);

        } else {
            return false;
        }
    }
}