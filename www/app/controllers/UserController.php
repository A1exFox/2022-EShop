<?php

namespace app\controllers;

use app\models\User;

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

    public function loginAction()
    {
        if (User::checkAuth())
            redirect(base_url());

        if (!empty($_POST)) {
            if ($this->model->login()) {
                $_SESSION['success'] = ___('user_login_success_login');
                redirect(base_url());
            } else {
                $_SESSION['errors'] = ___('user_login_error_login');
                redirect();
            }
        }

        $this->setMeta(___('tpl_login'));
    }

    public function logoutAction()
    {
        if (User::checkAuth())
            unset($_SESSION['user']);
        redirect(base_url() . 'user/login');
    }
}