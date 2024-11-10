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
            if (!$this->model->validate($data) || !$this->model->checkUnique()) {
                $this->model->getErrors();
                $_SESSION['form_data'] = $data;
            } else {
                $pass = $this->model->attributes['password'];
                $this->model->attributes['password'] = password_hash($pass, PASSWORD_DEFAULT);
                if ($this->model->save('user'))
                    $_SESSION['success'] = ___('user_signup_success_register');
                else 
                    $_SESSION['errors'] = ___('user_signup_error_register');
            }
            redirect();
        }
        
        $this->setMeta(___('tpl_signup')); 
    }
}