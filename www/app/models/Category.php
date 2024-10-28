<?php

namespace app\models;

use RedBeanPHP\R;
use wfm\App;

class Category extends AppModel
{
    public function get_category($slug, $lang) 
    {
        $sql = "
            SELECT c.*, cd.*
            FROM category c
            JOIN category_description cd
            ON c.id = cd.category_id
            WHERE c.slug = ?
            AND cd.language_id = ?";
        
        $query = R::getRow($sql, [$slug, $lang['id']]);
        return $query;
    }

    public function getIds($id): string
    {
        $lang = App::$app->getProperty('language')['code'];
        $categories = App::$app->getProperty("categories_{$lang}");
        $ids = '';
        foreach($categories as $k => $v) {
            if ($v['parent_id'] == $id) {
                $ids .= $k . ',';
                $ids .= $this->getIds($k);
            }
        }
        return $ids;
    }

    public function get_products($ids, $lang, $start, $perpage): array 
    {
        $sql = "
            SELECT p.*, pd.* 
            FROM product p 
            JOIN product_description pd 
            ON p.id = pd.product_id 
            WHERE p.status = 1
            AND p.category_id 
            IN ($ids) 
            AND pd.language_id = ?
            LIMIT $start,$perpage";
        $query = R::getAll($sql, [$lang['id']]);
        return $query;
    }

    public function get_count_products($ids): int
    {
        $sql = "category_id IN ($ids)";
        $count = R::count('product', $sql);
        return $count;
    }
}