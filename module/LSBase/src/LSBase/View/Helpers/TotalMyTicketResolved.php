<?php
namespace LSBase\View\Helpers;

use Zend\View\Helper\AbstractHelper;

/**
 * TotalMyTicketResolved
 *
 * @package LSBase\View\Helpers
 * @author Jesus Vieira <jesusvieiradelima@gmail.com>
 * @version  v1.0
 */
class TotalMyTicketResolved extends AbstractHelper
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