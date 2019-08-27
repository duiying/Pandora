<?php

namespace app\web\controllers;

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
    public function actionIndex()
    {
        echo '<h1>Pandora</h1>';
    }
}