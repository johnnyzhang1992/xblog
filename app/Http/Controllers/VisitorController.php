<?php
/**
 * Created by PhpStorm.
 * User: zq199
 * Date: 2016/11/17
 * Time: 17:41
 */
namespace App\Http\Controllers;


class VisitorController extends Controller
{
    protected $imageRepository;
    protected $cssRepository;
    protected $jsRepository;
    protected $fontRepository;

    /**
     * VisitorsController constructor.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }


    public function visitors()
    {
        $content = '没错这就是浏览统计页面';

        return view('admin.visitors',compact('content') );
    }
}