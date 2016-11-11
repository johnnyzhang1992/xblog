<?php
/**
 * Created by PhpStorm.
 * User: lufficc
 * Date: 2016/9/20
 * Time: 18:02
 */

namespace Lufficc\ExceptionHandler;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;
use Laravel\Socialite\Two\InvalidStateException;

class BlogExceptionHandler
{
    /**
     * @param $request
     * @param Exception $exception
     * @return mixed
     */
    public function handler(Request $request, Exception $exception)
    {
        if ($request->ajax()) {
            return response()->json(
                ['status' => $exception->getCode(), 'msg' => $exception->getMessage()]
            );
        }
        return false;
    }
}