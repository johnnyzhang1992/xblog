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
           'username', 'email','ip','device', 'os', 'os_version', 'browser', 'browser_version', 'robot', 'created_at'
        ];

        $_visitors = DB::table('visitor_tracking')
            ->distinct()
            ->select($_fields)
            ->where('created_at', '>', DB::raw('CURDATE()'))
//            ->where('created_at', '<', DB::raw("now()::date + interval '1 day'"))
            ->orderBy('created_at', 'desc')
            ->get();


        return view('admin.visitors')
            ->with(['visitors' => $_visitors]);
    }
}