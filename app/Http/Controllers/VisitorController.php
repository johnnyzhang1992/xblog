<?php
/**
 * Created by PhpStorm.
 * User: zq199
 * Date: 2016/11/17
 * Time: 17:41
 */
namespace App\Http\Controllers;

use App\Http\Repositories\UserRepository;

use DB;
use App\User;
use Illuminate\Http\Request;


class VisitorController extends Controller
{
    protected $userRepository;

    /**
     * VisitorsController constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->middleware(['auth', 'admin']);
    }


    public function visitors()
    {
        $_fields = [
            DB::raw("distinct on (session_id) session_id"), 'username', 'email', 'geoinfo', 'ip',
            'device', 'os', 'os_version', 'browser', 'browser_version', 'robot', 'created_at'
        ];

        $_visitors = DB::table('visitor_tracking')
            ->select($_fields)
            ->where('created_at', '>', DB::raw('now()::date'))
            ->where('created_at', '<', DB::raw("now()::date + interval '1 day'"))
//            ->groupBy('id', 'session_id')
            ->orderBy('created_at', 'desc')
            ->get();


        return view('manage.modules.visitor_tracking.index')
            ->with(['visitors' => $_visitors]);
//        $content = '没错这就是浏览统计页面';
//
//        return view('admin.visitors',compact('content') );
    }
}