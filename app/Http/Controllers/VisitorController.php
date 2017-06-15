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
//        $_fields = [
//          'username', 'email', 'ip', 'device', 'os', 'os_version', 'browser', 'browser_version', 'robot', 'created_at'
//        ];
        $_visitors = DB::table('visitor_tracking')
//            ->select($_fields)
            ->where([['created_at', '>', DB::raw('CURRENT_DATE')]])
            ->orderBy('created_at', 'desc')
            ->distinct()
            ->get();
        $_visitors_count = DB::table('visitor_tracking')
            ->where([['created_at', '>', DB::raw('CURRENT_DATE')]])
            ->count(DB::raw('DISTINCT ip'));

        return view('admin.visitors')
            ->with([
                'visitors' => $_visitors,
                'visitors_count' =>$_visitors_count
            ]);
    }
}