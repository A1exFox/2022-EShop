<?php

namespace app\models;

use RedBeanPHP\R;

class Page extends AppModel
{
    public function get_page($slug, $lang):array
    {
        $sql = "
            SELECT p.*,pd.*
            FROM page p
            JOIN page_description pd
            ON p.id = pd.page_id
            WHERE pd.language_id = ?
            AND p.slug = ?";
        $query = R::getRow($sql, [$lang['id'], $slug]);
        return $query;
    }
}