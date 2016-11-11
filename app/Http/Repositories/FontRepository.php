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
class FontRepository extends FileRepository
{
    static $tag = 'font';

    public function uploadFont(Request $request)
    {
        $file = $request->file('file');
        return $this->uploadFile($file, $file->getClientOriginalName());
    }

    public function tag()
    {
        return FontRepository::$tag;
    }

    public function type()
    {
        return FontRepository::$tag;
    }
}