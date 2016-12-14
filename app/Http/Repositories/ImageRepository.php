<?php
/**
 * Created by PhpStorm.
 * User: lufficc
 * Date: 2016/8/19
 * Time: 17:41
 */
namespace App\Http\Repositories;

use App\File;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Storage;


/**
 * Class TagRepository
 * @package App\Http\Repository
 */
class ImageRepository extends FileRepository
{
    static $tag = 'image';

    public function getAll($page = 12)
    {
        $maps = $this->remember('image.page.' . $page . request()->get('page', 1), function () use ($page) {
            return File::where('type', 'image')->orderBy('created_at', 'desc')->paginate($page);
        });
        return $maps;
    }

    public function uploadImage(UploadedFile $file, $key)
    {
        return $this->uploadFile($file, $key);
    }

    public function uploadImageToQiNiu(Request $request, $html)
    {
        $file = $request->file('image');
        $data = [];
        $url = $this->uploadFile($file);
        if ($url) {
            if ($html) {
                return true;
            } else {
                $data['filename'] = $url;
            }
        } else {
            if ($html)
                return false;
            $data['error'] = 'upload failed';
        }
        return $data;
    }

    public function uploadImageToLocal(Request $request)
    {
        $file = $request->file('image');
        $path = $file->store('public/images');
        $url = Storage::url($path);

        if ($path) {
            $image = File::firstOrNew([
                'name' => $file->getClientOriginalName(),
                'key' => $url,
                'size' => $file->getSize(),
                'type' => 'image',
                'from' => 'local'
            ]);
            $result = $image->save();
        } else {
            $result = false;
        }
        $this->clearCache();
        return $path;
    }
    public function uploadImageToTravel(Request $request)
    {
        $file = $request->file('image');
        $poi_id = $request->input('poi_id');
        $user_id = $request->input('user_id');
        $path = $file->store('public/images/travel/'.$poi_id);
        $url = Storage::url($path);

        if ($path) {
            $_image['poi_id'] =$poi_id;
            $_image['user_id'] = $user_id;
            $_image['name'] = $file->getClientOriginalName();
            $_image['uri'] = $url;
            $_image['size'] = $file->getSize();
            $_image['type'] = 'image';
//            $result = $image->save();
            DB::table('travel_files')->insert($_image);
        } else {
        }
        $this->clearCache();
        return $path;
    }
    public function uploadTravelCoverImage(Request $request){
        $file = $request->file('image');
        $poi_id = $request->input('poi_id');
        $user_id = $request->input('user_id');
        $path = $file->store('public/images/travel/'.$poi_id.'/cover_image');
        $url = Storage::url($path);

        if ($path) {
            $_image['poi_id'] =$poi_id;
            $_image['user_id'] = $user_id;
            $_image['name'] = $file->getClientOriginalName();
            $_image['uri'] = $url;
            $_image['size'] = $file->getSize();
            $_image['type'] = 'image';
//            $result = $image->save();
//            DB::table('travel_files')->insert($_image);
            DB::table('travel')->where('id','=',$poi_id)->update('cover_image',$_image['uri']);
        } else {
        }
        $this->clearCache();
        return $path;
    }

    public function count()
    {
        $count = $this->remember($this->tag() . '.count', function () {
            return File::where('type', $this->type())->count();
        });
        return $count;
    }

    public function tag()
    {
        return ImageRepository::$tag;
    }

    public function type()
    {
        return ImageRepository::$tag;
    }
}