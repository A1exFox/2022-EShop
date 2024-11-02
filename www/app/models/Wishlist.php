<?php

namespace app\models;

use RedBeanPHP\R;

class Wishlist extends AppModel
{
    public function get_product($id): array|null|string
    {
        $sql = "
            SELECT id
            FROM product
            WHERE status = 1
            AND id = ?";
        $query = R::getCell($sql, [$id]);
        return $query;
    }

    public function add_to_wishlist($id)
    {
        $wishlist = self::get_wishlist_ids();
        if (!$wishlist) {
            setcookie('wishlist', $id, time() + 3600*24*7*30, '/');
            return;
        }

        if (in_array($id, $wishlist))
            return;

        if (count($wishlist) > 5)
            array_shift($wishlist);
        
        $wishlist[] = $id;
        $wishlist = implode(',',$wishlist);
        setcookie('wishlist', $wishlist, time() + 3600 * 24 * 7 * 30, '/');
   
    }

    public static function get_wishlist_ids():array
    {
        $wishlist = $_COOKIE['wishlist'] ?? '';
        if ($wishlist) 
            $wishlist = explode(',', $wishlist);

        if (is_array($wishlist)) {
            $wishlist = array_slice($wishlist, 0, 6);
            $wishlist = array_map('intval', $wishlist);
            return $wishlist;
        }
        return [];
    }
}