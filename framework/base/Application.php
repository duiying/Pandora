<?php

namespace pandora\base;

use Exception;
use pandora\Pandora;

/**
 * 基础应用类
 *
 * PHP version 7
 *
 * @category  PHP
 * @author    wangyaxian <wangyaxiandev@gmail.com>
 * @link      https://github.com/duiying/Pandora
 */
abstract class Application
{
    /**
     * 应用启动入口
     *
     * @return Exception
     */
    public function run()
    {
        // 框架核心类初始化
        Pandora::init();

        try {
            return $this->handle();
        } catch (Exception $e) {
            return $e;
        }
    }

    /**
     * 处理方法
     *
     * @return mixed
     */
    abstract public function handle();
}