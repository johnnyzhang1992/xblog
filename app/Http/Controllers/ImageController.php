<?php

namespace App\Http\Controllers;

use App\Http\Repositories\ImageRepository;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    protected $imageRepository;

    /**
     * ImageController constructor.
     * @param $imageRepository
     */
    public function __construct(ImageRepository $imageRepository)
    {
        $this->imageRepository = $imageRepository;
        $this->middleware(['auth', 'admin']);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function images()
    {
        $images = $this->imageRepository->getAll();
        $image_count = $this->imageRepository->count();
        return view('admin.images', compact('images','image_count'));
    }

    /**
     * @param Request $request
     * @return mixed
     * 上传文件到七牛
     */
    public function uploadImage(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|image|max:5000'
        ]);
        $type = $request->input('type', null);
        if ($type != null && $type == 'xrt') {
            return $this->imageRepository->uploadImageToQiNiu($request, false);
        } else {
            if ($this->imageRepository->uploadImageToQiNiu($request, true))
                return back()->with('success', '上传成功');
            return back()->withErrors('上传失败');
        }
    }
    public function uploadImageToLocal(Request $request){
        $this->validate($request, [
            'image' => 'required|image|max:5000'
        ]);
        $type = $request->input('type', null);
        if ($type != null && $type == 'xrt') {
            return $this->imageRepository->uploadImageToLocal($request);
        } else {
            if ($this->imageRepository->uploadImageToLocal($request))
                return back()->with('success',$this->imageRepository->uploadImageToLocal($request) );
            return back()->withErrors('上传失败');
        }
    }
    /**
     * 上传图片到Travel
     */
    public function uploadImageToTravel(Request $request){
        $this->validate($request, [
            'image' => 'required|image|max:50000'
        ]);
        $type = $request->input('type', null);
        if ($type != null && $type == 'xrt') {
            return $this->imageRepository->uploadImageToTravel($request);
        } else {
            if ($this->imageRepository->uploadImageToTravel($request))
                return back()->with('success','上传成功' );
            return back()->withErrors('上传失败');
        }
    }
    /**
     * 上传poi的封面图
     */
    public function uploadTravelCoverImage(Request $request){
        $this->validate($request, [
            'image' => 'required|image|max:500000'
        ]);
        $type = $request->input('type', null);
        if ($type != null && $type == 'xrt') {
            return $this->imageRepository->uploadTravelCoverImage($request);
        } else {
            if ($this->imageRepository->uploadTravelCoverImage($request))
                return back()->with('success','封面上传成功' );
            return back()->withErrors('上传失败');
        }
    }
    /**
     * 上传书籍的封面图
     */
    public function uploadBookCoverImage(Request $request){
        $this->validate($request, [
            'image' => 'required|image|max:500000'
        ]);
        $type = $request->input('type', null);
        if ($type != null && $type == 'xrt') {
            return $this->imageRepository->uploadBookCoverImage($request);
        } else {
            if ($this->imageRepository->uploadBookCoverImage($request))
                return back()->with('success','封面上传成功' );
            return back()->withErrors('上传失败');
        }
    }
    /**
     * summernote 编辑器图片上传部分改造
     */
    public function uploadImageByAjax(Request $request){
        $file = $request->file('file');
        $poi_id = $request->input('poi_id');
        $poi_type = $request->input('poi_type');
        // 获取文件相关信息
//        $originalName = $file->getClientOriginalName(); // 文件原名
//        $ext = $file->getClientOriginalExtension();     // 扩展名
//        $realPath = $file->getRealPath();   //临时文件的绝对路径
//        $img_type = $file->getClientMimeType();     // image/jpeg
        $path = $file->store('/images/'.$poi_type.'/'.$poi_id.'/','public');
        return asset($path);
    }

}
