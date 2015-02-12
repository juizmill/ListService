<?php

namespace Application\Controller;

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
