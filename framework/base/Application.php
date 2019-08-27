<?php

namespace pandora\base;

use Exception;

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