<?php
/**
 * Created by PhpStorm.
 * User: lufficc
 * Date: 2016/8/19
 * Time: 17:41
 */
namespace App\Http\Repositories;

use Illuminate\Http\Request;


/**
 * Class TagRepository
 * @package App\Http\Repository
 */
class JsRepository extends FileRepository
{
    static $tag = 'js';

    public function uploadJs(Request $request)
    {
        $this->deleteAllByType();
        $file = $request->file('file');
        return $this->uploadFile($file, $file->getClientOriginalName());
    }

    public function tag()
    {
        return JsRepository::$tag;
    }

    public function type()
    {
        return 'js';
    }
}