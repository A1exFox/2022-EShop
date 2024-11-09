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
            if (!$this->model->validate($data))
                $this->model->getErrors();
            else
                $_SESSION['success'] = ___('user_signup_success_register');
            redirect();
        }
        
        $this->setMeta(___('tpl_signup')); 
    }
}