<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;

class CategoryController extends AbstractController
{
    public function __construct()
    {
        $this->entity = 'Application\\Entity\\Category';
        $this->controller = 'category';
        $this->form = 'category.form';
        $this->route = 'category';
    }
}
