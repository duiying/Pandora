<?php

namespace pandora\web;

/**
 * WEB控制器
 *
 * PHP version 7
 *
 * @category  PHP
 * @author    wangyaxian <wangyaxiandev@gmail.com>
 * @link      https://github.com/duiying/Pandora
 */
class Controller extends \pandora\base\Controller
{
    /**
     * 将数据转为JSON
     *
     * @param $data
     * @return false|string
     */
    public function json($data)
    {
        return is_string($data) ? $data : json_encode($data);
    }
}