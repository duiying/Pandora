<?php

namespace app\web\models;

use pandora\base\Model;

/**
 * 用户模型
 *
 * @package app\web\models
 */
class User extends Model
{
    /**
     * 表名
     *
     * @return string
     */
    public static function tableName()
    {
        return 'user';
    }
}