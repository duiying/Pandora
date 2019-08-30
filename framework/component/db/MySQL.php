<?php

namespace pandora\component\db;

use PDO;
use pandora\base\Component;

/**
 * MySQL组件
 *
 * PHP version 7
 *
 * @category  PHP
 * @author    wangyaxian <wangyaxiandev@gmail.com>
 * @link      https://github.com/duiying/Pandora
 */
class MySQL extends Component
{
    /**
     * @var 私有的静态属性
     */
    private static $instance;

    /**
     * @var 数据源
     */
    public static $dsn;

    /**
     * @var 用户名
     */
    public static $user;

    /**
     * @var 密码
     */
    public static $pass;

    /**
     * @var 连接选项
     */
    public static $options;

    /**
     * 私有的构造方法
     */
    private function __clone()
    {

    }

    /**
     * 私有的构造方法
     */
    private function __construct()
    {

    }

    /**
     * 获取PDO实例
     *
     * @return PDO
     */
    public static function getInstance()
    {
        if (self::$instance === NULL) {
            self::$instance = new PDO(self::$dsn, self::$user, self::$pass, self::$options);
            self::$instance->exec("set names 'utf8'");
        }
        return self::$instance;
    }
}