<?php

namespace app\controllers;

use wfm\App;
use app\models\Breadcrumbs;

class ProductController extends AppController
{
    public function viewAction()
    {
        $lang = App::$app->getProperty('language');
        $product = $this->model->get_product($this->route['slug'], $lang);
        
        if (!$product)
            throw new Exception("Товар по запросу <b>{$this->route['slug']}</b> не найден");


        $breadcrumbs = Breadcrumbs::getBreadcrumbs($product['category_id'], $product['title']);
        $gallery = $this->model->get_gallery($product['id']);

        $this->setMeta($product['title'], $product['description'], $product['keywords']);
        $this->set(compact('product', 'gallery', 'breadcrumbs'));
    }
}