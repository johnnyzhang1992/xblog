<?php
/**
 * Created by PhpStorm.
 * User: lufficc
 * Date: 2016/10/8
 * Time: 15:34
 */

namespace App\Contracts;


use Closure;

interface XblogCache
{
    public function setTag($tag);


    public function setTime($time_in_minute);

    public function remember($key, Closure $entity, $tag = null);

    public function forget($key, $tag = null);

    public function clearCache($tag = null);

    public function clearAllCache();
}