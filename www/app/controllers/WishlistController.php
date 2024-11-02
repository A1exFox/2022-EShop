<?php

namespace app\controllers;

class WishlistController extends AppController
{
    public function addAction()
    {
        $id = get('id');
        if (!$id) {
            $answer = [
                'result' => 'error', 
                'text' => ___('tpl_wishlist_add_error')
            ];
            exit(json_encode($answer));
        }

        $product = $this->model->get_product($id);
        if (!$product) {
            $answer = [
                'result' => 'error',
                'text' => ___tpl('tpl_wishlist_add_error'),
            ];
            exit(json_encode($answer));
        }

        $this->model->add_to_wishlist($id);
        $answer = [
            'result' => 'success',
            'text' => ___('tpl_wishlist_add_success'),
        ];
        exit(json_encode($answer));

    }
}