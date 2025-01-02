<?php

namespace App\Controllers;

use App\Views\View;

class MainController
{
    private View $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../Templates/');
    }

    public function main()
    {
        $this->view->render('main.php');
    }
}