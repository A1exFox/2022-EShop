<?php

namespace app\controllers;

use app\models\AppModel;
use app\widgets\language\Language;
use wfm\App;
use wfm\Controller;
use RedBeanPHP\R;
use app\models\Wishlist;

class AppController extends Controller
{
    public function __construct($route)
    {
        parent::__construct($route);
        new AppModel();
        $langs = Language::getLanguages();
        App::$app->setProperty('languages', $langs);
        App::$app->setProperty('language', Language::getLanguage($langs));

        $lang = App::$app->getProperty('language');
        \wfm\Language::load($lang['code'], $route);

        $categories = R::getAssoc(
            "SELECT c.*, cd.*
            FROM category c
            JOIN category_description cd
            ON c.id = cd.category_id
            WHERE cd.language_id = ?",
            [$lang['id']]);

        App::$app->setProperty("categories_{$lang['code']}", $categories);
        App::$app->setProperty('wishlist', Wishlist::get_wishlist_ids());
    }
}











