<?php

namespace app\controllers;

use wfm\Controller;

class MainController extends Controller
{
    public function indexAction()
    {
        $this->setMeta('Index page', 'Description index page', 'Keywords index page');
    }
}













