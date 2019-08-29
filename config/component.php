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
    // MySQL
    'db' => [
        'class' => '\pandora\component\db\MySQL',
        'dsn' => 'mysql:host=mysql;dbname=pandora',
        'username' => 'root',
        'password' => 'root',
        'options' => [
            \PDO::ATTR_EMULATE_PREPARES => false,
            \PDO::ATTR_STRINGIFY_FETCHES => false,
        ],
    ],
];