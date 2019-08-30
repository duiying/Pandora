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
    }
}