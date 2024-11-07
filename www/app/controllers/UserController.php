<?php

namespace app\controllers;

class UserController extends AppController
{
    public function signupAction()
    {
        if ($this->model->checkAuth())
            redirect(base_url());

        if (!empty($_POST)) {
            $data = $_POST;
            $this->model->load($data);
            debug($this->model->attributes, true);
        }
        
        $this->setMeta(___('tpl_signup')); 
    }
}