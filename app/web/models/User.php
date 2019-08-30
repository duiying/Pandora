<?php

namespace app\web\models;

use pandora\base\Model;

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