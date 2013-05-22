<?php

namespace LSCategoryticket\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * CategoryTicketRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategoryTicketRepository extends EntityRepository
{
    /**
     * fetchPairs
     *
     * Monta um array com o ID e a descrição,
     *
     * @return array
     */
    public function fetchPairs ()
    {
        $categoryTickets = $this->findBy(array('active' => true));
        $array = array();

        foreach ( $categoryTickets as $categoryTicket )
            $array[$categoryTicket->getId ()] = $categoryTicket->getDescription ();

        return $array;
    }

    /**
     * fetchAllCategoryTicketActive
     *
     * Retorna todas as  categorias de ticket ativos
     *
     * @return array
     */
    public function fetchAllCategoryTicketActive()
    {
        $query = "SELECT c.id, c.description FROM LSCategoryticket\\Entity\\CategoryTicket c WHERE c.active = true";

        return $this->_em->createQuery($query)->getResult();
    }
}
