<?php

namespace pandora\component\cache;

use pandora\base\Component;

/**
 * 文件缓存组件
 *
 * PHP version 7
 *
 * @category  PHP
 * @author    wangyaxian <wangyaxiandev@gmail.com>
 * @link      https://github.com/duiying/Pandora
 */
class FileCache extends Component
{
    /**
     * @var 缓存文件
     */
    public static $cacheFilePath;

    /**
     * 初始化方法
     */
    public function init()
    {
        mkdir(self::$cacheFilePath, 0777, true);
    }

    /**
     * 生成key
     *
     * @param $key
     * @return string
     */
    public function buildKey($key)
    {
        if (!is_string($key)) {
            $key = json_encode($key);
        }
        return md5($key);
    }

    /**
     * 获取指定key的值
     *
     * @param $key
     * @return bool|mixed
     */
    public function get($key)
    {
        $key = $this->buildKey($key);
        $cacheFile = self::$cacheFilePath . $key;
        // 用文件修改时间来维护缓存的有效期
        if (file_exists($cacheFile) && @filemtime($cacheFile) > time()) {
            return unserialize(file_get_contents($cacheFile));
        }
        return false;
    }

    /**
     * 检查指定key是否存在
     *
     * @param $key
     * @return bool
     */
    public function exists($key)
    {
        $key = $this->buildKey($key);
        $cacheFile = self::$cacheFilePath . $key;
        // 用文件修改时间来维护缓存的有效期
        return @filemtime($cacheFile) > time();
    }

    /**
     * 设置指定key的值
     *
     * @param $key
     * @param $value
     * @param int $duration 缓存过期时间(秒数)，默认为1年
     * @return bool
     */
    public function set($key, $value, $duration = 31536000)
    {
        $key = $this->buildKey($key);
        $cacheFile = self::$cacheFilePath . $key;

        // 序列化缓存内容
        $value = serialize($value);

        // 将序列化之后的内容写入文件，LOCK_EX表示写入时会对文件加锁
        if (file_put_contents($cacheFile, $value, LOCK_EX) !== false) {
            // 设置修改时间，缓存过期时间为当前时间加上$duration
            return touch($cacheFile, $duration + time());
        } else {
            return false;
        }
    }

    /**
     * 删除指定key的值
     *
     * @param $key
     * @return bool
     */
    public function delete($key)
    {
        $key = $this->buildKey($key);
        $cacheFile = self::$cacheFilePath . $key;
        // 删除缓存文件
        return unlink($cacheFile);
    }

    /**
     * 删除所有缓存
     */
    public function flush()
    {
        $dir = self::$cacheFilePath;
        if ($handle = opendir($dir)) {
            while (($file = readdir($handle)) !== false) {
                if ($file !== '.' && $file !== '..') {
                    unlink($dir . '/' . $file);
                }
            }
            closedir($handle);
        }
        return true;
    }
}