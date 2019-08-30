<?php

namespace pandora;

/**
 * 框架核心类
 *
 * PHP version 7
 *
 * @category  PHP
 * @author    wangyaxian <wangyaxiandev@gmail.com>
 * @link      https://github.com/duiying/Pandora
 */
class Pandora
{
    /**
     * @var 组件配置
     */
    private static $componentConfig = NULL;

    /**
     * @var string 组件配置文件
     */
    private static $componentConfigFile = CONFIG_PATH . '/component.php';

    /**
     * 框架核心类初始化
     */
    public static function init()
    {
        // 将组件配置保存在$componentConfig中
        if (self::$componentConfig === NULL) {
            self::$componentConfig = require_once self::$componentConfigFile;
        }
    }

    /**
     * 获取组件实例
     *
     * @param $componentName 组件名称
     * @return mixed
     */
    public static function component($componentName)
    {
        // 组件配置
        $componentConfig = self::$componentConfig[$componentName];
        // 组件类
        $componentClass = $componentConfig['class'];
        unset($componentConfig['class']);

        // 给静态属性赋值
        foreach ($componentConfig as $attrName => $attrValue) {
            $componentClass::$$attrName = $attrValue;
        }

        // 判断是否是单例
        $single = method_exists($componentClass, 'getInstance');

        // 单例模式则返回单例，否则新建对象
        $instance = $single ? $componentClass::getInstance() : new $componentClass();

        // MySQL对象变为PDO对象后，init方法不存在，故作以下检查
        method_exists($instance, 'init') && $instance->init();

        // 返回实例
        return $instance;
    }
}