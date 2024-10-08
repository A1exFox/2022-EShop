<?php

namespace app\controllers;

use app\models\AppModel;
use app\widgets\language\Language;
use wfm\App;
use wfm\Controller;

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
    }
}











