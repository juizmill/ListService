<?php
namespace LSBase\View\Helpers;

use Zend\View\Helper\AbstractHelper;

/**
 * TotalMyTicketOngoing
 *
 * @package LSBase\View\Helpers
 * @author Jesus Vieira <jesusvieiradelima@gmail.com>
 * @version  v1.0
 */
class TotalMyTicketOngoing extends AbstractHelper
{

    protected $total;

    public function __construct(array $total = array())
    {
        $this->total = $total;
    }

    public function __invoke()
    {
        $total =$this->total;

        return $total[0][1];
    }

}
