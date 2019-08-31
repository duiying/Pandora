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
    public static function findAll(array $condition = [])
    {
        list($where, $params) = self::buildWhere($condition);

        // where条件不为空的时候才拼接where条件
        if ($where === ' where ') {
            $sql = 'select * from ' . static::tableName();
        } else {
            $sql = 'select * from ' . static::tableName() . $where;
        }

        $stmt = Pandora::component('db')->prepare($sql);

        if (empty($params)) {
            $res = $stmt->execute();
        } else {
            $res = $stmt->execute($params);
        }

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
     * 创建记录
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

        // 将主键赋值给模型
        $primaryKey = static::primaryKey();
        $lastInsertId = Pandora::component('db')->lastInsertId($primaryKey);
        $this->$primaryKey = $lastInsertId;

        return $res;
    }

    /**
     * 更新多条记录
     *
     * @param array $condition
     * @param array $attributes
     * @return mixed
     */
    public static function updateAll(array $condition, array $attributes)
    {
        $sql = 'update ' . static::tableName();
        $sql .= ' set ';

        $params = array_values($attributes);

        // 字段名
        $keys = [];

        foreach ($attributes as $key => $value) {
            array_push($keys, "$key = ?");
        }

        $sql .= implode(' , ', $keys);


        list($where, $params) = self::buildWhere($condition, $params);

        $sql .= $where;

        $stmt = Pandora::component('db')->prepare($sql);

        $res = $stmt->execute($params);
        if ($res) {
            // 获取更新的行数
            $res = $stmt->rowCount();
        }
        return $res;
    }

    /**
     * 更新单条记录
     *
     * @return mixed
     */
    public function update()
    {
        $primaryKeys = static::primaryKey();

        $primaryKey = static::primaryKey();

        $condition = [$primaryKey => $this->$primaryKey];

        $attributes = [];
        foreach ($this as $attrName => $attrValue) {
            if ($attrName != $primaryKey) {
                $attributes[$attrName] = $attrValue;
            }
        }

        return static::updateAll($condition, $attributes);
    }

    /**
     * 删除多条记录
     *
     * @param $condition
     * @return mixed
     */
    public static function deleteAll(array $condition)
    {
        list($where, $params) = static::buildWhere($condition);

        $sql = 'delete from ' . static::tableName() . $where;

        $stmt = Pandora::component('db')->prepare($sql);

        $res = $stmt->execute($params);
        if ($res) {
            // 获取删除的行数
            $res = $stmt->rowCount();
        }
        return $res;
    }

    /**
     * 删除单条记录
     *
     * @return mixed
     */
    public function delete()
    {
        $primaryKey = static::primaryKey();

        $condition = [$primaryKey => $this->$primaryKey];

        return static::deleteAll($condition);
    }
}