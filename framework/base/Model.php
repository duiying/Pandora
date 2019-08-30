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
     * 主键
     *
     * @return string
     */
    public static function primaryKey()
    {
        return 'id';
    }

    /**
     * 数组转为模型
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
     * @param array $condition 查询条件
     * @param array $params 参数
     * @return array
     */
    public static function buildWhere(array $condition = [], array $params = [])
    {
        $where = '';
        $where .= ' where ';

        // 字段名
        $keys = [];

        foreach ($condition as $key => $value) {
            array_push($keys, "$key = ?");
            array_push($params, $value);
        }
        $where .= implode(' and ', $keys);
        return [$where, $params];
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
     * 查询单条记录
     *
     * @param array $condition 查询条件
     * @return object|null|bool
     */
    public static function findOne(array $condition)
    {
        if (empty($condition)) {
            return false;
        }

        list($where, $params) = self::buildWhere($condition);

        $sql = 'select * from ' . static::tableName() . $where;

        $stmt = Pandora::component('db')->prepare($sql);

        $res = $stmt->execute($params);

        if ($res) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!empty($row)) {
                return self::arr2Model($row);
            }
        }

        return null;
    }

    /**
     * 创建一条记录
     *
     * @return mixed
     */
    public function create()
    {
        $sql = 'insert into ' . static::tableName();

        $params = [];

        // 字段名
        $keys = [];

        foreach ($this as $attrName => $attrValue) {
            array_push($keys, $attrName);
            array_push($params, $attrValue);
        }

        // 构建由?组成的数组
        $holders = array_fill(0, count($keys), '?');
        $sql .= ' (' . implode(',', $keys) . ') values (' . implode(',', $holders) . ')';

        $stmt = Pandora::component('db')->prepare($sql);

        $res = $stmt->execute($params);

        $primaryKey = static::primaryKey();

        // 将主键赋值给模型
        $primaryKey = static::primaryKey();
        $lastInsertId = Pandora::component('db')->lastInsertId($primaryKey);
        $this->$primaryKey = $lastInsertId;

        return $res;
    }
}