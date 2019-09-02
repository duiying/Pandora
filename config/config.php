<?php

/**
 * 组件配置
 *
 * PHP version 7
 *
 * @category  PHP
 * @author    wangyaxian <wangyaxiandev@gmail.com>
 * @link      https://github.com/duiying/Pandora
 */
return [
    // 默认控制器
    'defaultController' => 'site',
    // 默认方法
    'defaultAction' => 'index',
    // 组件
    'components' => [
        // MySQL
        'db' => [
            'class' => '\pandora\component\db\MySQL',
            'dsn' => 'mysql:host=mysql;dbname=pandora',
            'user' => 'root',
            'pass' => 'root',
            'options' => [
                \PDO::ATTR_EMULATE_PREPARES => false,
                \PDO::ATTR_STRINGIFY_FETCHES => false,
            ],
        ],
        // 文件缓存
        'fileCache' => [
            'class' => '\pandora\component\cache\FileCache',
            'cacheFilePath' => ROOT_PATH . '/runtime/cache/',
        ],
    ],
];