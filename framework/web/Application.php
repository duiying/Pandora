<?php

namespace pandora\web;

/**
 * WEB应用类
 *
 * PHP version 7
 *
 * @category  PHP
 * @author    wangyaxian <wangyaxiandev@gmail.com>
 * @link      https://github.com/duiying/Pandora
 */
class Application extends \pandora\base\Application
{
    /**
     * @var string 控制器命名空间
     */
    private $controllerNamespace = 'app\\web\\controllers\\';

    /**
     * 处理方法
     *
     * @return mixed
     */
    public function handle()
    {
        // 路由
        $router = $_GET['r'];
        list($controllerName, $actionName) = explode('/', $router);
        $controllerNameWithNamespace = $this->controllerNamespace . ucfirst($controllerName) . 'Controller';
        $controller = new $controllerNameWithNamespace();

        // 控制器
        $controller->id = $controllerName;
        // 方法
        $controller->action = $actionName;

        // 调用
        return call_user_func([$controller, 'action' . ucfirst($actionName)]);
    }
}