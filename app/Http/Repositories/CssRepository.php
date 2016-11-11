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
class CssRepository extends FileRepository
{
    static $tag = 'css';

    public function uploadCss(Request $request)
    {
        $this->deleteAllByType();
        $file = $request->file('file');
        return $this->uploadFile($file, $file->getClientOriginalName());
    }

    public function tag()
    {
        return CssRepository::$tag;
    }


    public function type()
    {
        return CssRepository::$tag;
    }
}