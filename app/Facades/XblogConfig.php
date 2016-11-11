<?php
/**
 * Created by PhpStorm.
 * User: lufficc
 * Date: 2016/10/7
 * Time: 23:32
 */

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class XblogConfig extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'XblogConfig';
    }
}