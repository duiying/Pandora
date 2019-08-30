<?php

namespace pandora\base;

use pandora\Pandora;
use PDO;

/**
 * 基础模型类
 *
 * PHP version 7
 *
 * @category  PHP
 * @author    wangyaxian <wangyaxiandev@gmail.com>
 * @link      https://github.com/duiying/Pandora
 */
class Model
{
    /**
     * 获取表名
     *
     * @return string
     */
    public static function tableName()
    {
        return get_called_class();
    }

    /**
     * 查询多条记录
     *
     * @param array $condition 查询条件
     * @return array|bool
     */
    public static function findAll(array $condition)
    {
        if (empty($condition)) {
            return false;
        }

        list($where, $params) = self::buildWhere($condition);

        $sql = 'select * from ' . static::tableName() . $where;

        $stmt = Pandora::component('db')->prepare($sql);

        $res = $stmt->execute($params);

        $models = [];

        if ($res) {
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($rows as $row) {
                if (!empty($row)) {
                    $model = self::arr2Model($row);
                    array_push($models, $model);
                }
            }
        }

        return $models;
    }

    /**
     * 将数组转为模型类
     *
     * @param $row
     * @return MySQL
     */
    public static function arr2Model($row)
    {
        $model = new static();
        foreach ($row as $rowKey => $rowValue) {
            $model->$rowKey = $rowValue;
        }
        return $model;
    }

    /**
     * 构造where条件
     *
     * @param array $condition
     * @param array $params
     * @return array
     */
    public static function buildWhere(array $condition = [], array $params = [])
    {
        $where = '';
        $where .= ' where ';
        $keys = [];
        foreach ($condition as $key => $value) {
            array_push($keys, "$key = ?");
            array_push($params, $value);
        }
        $where .= implode(' and ', $keys);
        return [$where, $params];
    }
}