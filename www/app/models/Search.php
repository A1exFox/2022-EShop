<?php

namespace app\models;

use RedBeanPHP\R;

class Search extends AppModel
{
    public function get_count_find_products($s, $lang): int
    {
        $sql = "
            SELECT COUNT(*) 
            FROM product p 
            JOIN product_description pd
                ON p.id = pd.product_id 
            WHERE p.status = 1 
                AND pd.language_id = ?
                AND pd.title
                    LIKE ?";
        $query = R::getCell($sql, [$lang['id'], "%{$s}%"]);
        return $query;
    }

    public function get_find_products($s, $lang, $start, $perpage): array
    {
        $sql = "
            SELECT p.*, pd.*
            FROM product p
            JOIN product_description pd 
                ON p.id = pd.product_id
            WHERE p.status = 1
                AND pd.language_id = :lang_id
                AND pd.title
                    LIKE :search
                LIMIT :start,:perpage";
        
        $options = [
            'lang_id' => $lang['id'],
            'search' => "%{$s}%",
            'start' => $start,
            'perpage' => $perpage,
        ];
        $query = R::getAll($sql, $options);
        return $query;
    }
}