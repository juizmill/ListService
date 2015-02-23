<?php

namespace Application\Helpers;

use Zend\View\Helper\AbstractHelper;

/**
 * Class ContentHeader
 *
 * @package Application\Helpers
 */
class ContentHeader extends AbstractHelper
{
    public function __invoke($header = null, $content = null)
    {
        return "<h1>{$header}<small>{$content}</small></h1>";
    }
}
