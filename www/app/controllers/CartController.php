<?php

namespace app\controllers;

use app\models\Cart;
use wfm\App;
use app\models\User;

/** @property Cart $model */
class CartController extends AppController
{
    public function addAction()
    {
        $lang = App::$app->getProperty('language');
        $id = get('id');
        $qty = get('qty');
        if (!$id)
            return false;
        $product = $this->model->get_product($id, $lang);
        if (!$product)
            return false;

        $this->model->add_to_cart($product, $qty);

        if ($this->isAjax())
            $this->loadView('cart_modal');
 
        redirect();
        return true;
    }

    public function showAction()
    {
        $this->loadView('cart_modal');
    }

    public function deleteAction() 
    {
        $id = get('id');
        if (isset($_SESSION['cart'][$id])) {
            $this->model->delete_item($id);
        }
        if ($this->isAjax()) {
            $this->loadView('cart_modal');
        }
        redirect();
    }

    public function clearAction() 
    {
        if (empty($_SESSION['cart']))
            return false;
        unset($_SESSION['cart']);
        unset($_SESSION['cart.qty']);
        unset($_SESSION['cart.sum']);
        $this->loadView('cart_modal');
        return true;
    }

    public function viewAction()
    {
        $this->setMeta(___('tpl_cart_title'));
    }

    public function checkoutAction()
    {
        if (!empty($_POST)) {
            if (!User::checkAuth()) {
                $user = new User();
                $data = $_POST;
                $user->load($data);
                if (!$user->validate($data) || !$user->checkUnique()) {
                    $user->getErrors();
                    $_SESSION['form_data'] = $data;
                    redirect();
                } else {
                    $pass = $user->attributes['password'];
                    $user->attributes['password'] = password_hash($pass, PASSWORD_DEFAULT);
                    if (!$user_id = $user->save('user')) {
                        $_SESSION['errors'] = ___('cart_checkout_error_register');
                        redirect();
                    } else {

                    }
                }
            }
        }
        redirect();
    }
}










