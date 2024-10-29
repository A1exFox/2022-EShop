<?php

namespace app\controllers;

use wfm\App;
use app\models\Breadcrumbs;
use wfm\Pagination;

class CategoryController extends AppController 
{
    public function viewAction() 
    {
        $lang = App::$app->getProperty('language');
        $slug = $this->route['slug'];
        $category = $this->model->get_category($slug, $lang);

        if (!$category) {
            $this->error_404();
            return;
        }

        $breadcrumbs = Breadcrumbs::getBreadcrumbs($category['id']);

        $ids = $this->model->getIds($category['id']);
        $ids .= $category['id'];

        $page = get('page');
        $perpage = App::$app->getProperty('pagination');
        $total = $this->model->get_count_products($ids);

        $pagination = new Pagination($page, $perpage, $total);
        $start = $pagination->getStart();
        
        $products = $this->model->get_products($ids, $lang, $start, $perpage);

        $this->setMeta($category['title'], $category['description'], $category['keywords']);
        $this->set(compact('products', 'category', 'breadcrumbs', 'total', 'pagination'));
    }
}