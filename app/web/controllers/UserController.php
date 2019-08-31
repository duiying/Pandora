<?php

namespace app\web\controllers;

use app\web\models\User;
use pandora\web\Controller;

/**
 * 用户控制器
 *
 * PHP version 7
 *
 * @category  PHP
 * @author    wangyaxian <wangyaxiandev@gmail.com>
 * @link      https://github.com/duiying/Pandora
 */
class UserController extends Controller
{
    /**
     * 查询多条记录
     */
    public function actionSelect()
    {
        $users = User::findAll();
        echo $this->json($users);
    }

    /**
     * 创建记录
     */
    public function actionCreate()
    {
        $user = new User();
        $user->name = 'wyx';
        $user->age = 18;

        $res = $user->create();

        var_dump($res);
    }
}