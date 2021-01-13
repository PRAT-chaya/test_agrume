<?php

namespace App\Application\Controllers;

use App\Application\Views\View;

class Controller
{
    protected $view;
    protected $data;

    public function __construct(View $view)
    {
        $this->view = $view;
    }

    public function getView(): View
    {
        return $this->view;
    }
}