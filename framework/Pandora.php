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
     * @var null 本类实例
     */
    public static $app = NULL;

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
        // 将本类实例保存在$app中
        if (self::$app === NULL) {
            self::$app = new self();
        }

        // 将组件配置保存在$componentConfig中
        if (self::$componentConfig === NULL) {
            self::$componentConfig = require_once self::$componentConfigFile;
        }
    }

    public function __get($name)
    {
        var_dump(self::$componentConfig);
    }
}