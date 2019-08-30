<?php

namespace app\web\controllers;

use app\web\models\User;
use pandora\base\Controller;

/**
 * 控制器Site
 *
 * PHP version 7
 *
 * @category  PHP
 * @author    wangyaxian <wangyaxiandev@gmail.com>
 * @link      https://github.com/duiying/Pandora
 */
class SiteController extends Controller
{
    /**
     * 首页
     */
    public function actionIndex()
    {
        echo '<h1>Pandora</h1>';
    }


    public function actionSelect()
    {
        var_dump(User::findAll(['id' => 1]));
        var_dump(User::findOne(['id' => 2]));
    }

    public function actionCreate()
    {
        $user = new User();
        $user->name = 'duiying';
        $user->age = 18;
        var_dump($user->create());
    }
}