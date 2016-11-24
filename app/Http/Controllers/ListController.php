<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Map;
use App\User;
use DB;
use Illuminate\Http\Request;

class ListController extends Controller
{

    /**
     * ListController constructor.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);

    }

    /**
     * List homepage Controller
     */
    public function index()
    {
        $user = auth()->user();
        $_list = DB::table('list')
            ->where('list.user_id', $user->id)
            ->where('list.status', 'available')
            ->get();
        return view('list.index')->with('list', $_list);
    }

    //store
    public function store(Request $request){
        $user = auth()->user();
        $_list['user_id'] = $user->id;
        $_list['user_name'] = $user->name;
        $_list['status'] = 'available';
        $_list['title'] = $request['list_title'];
        DB::table('list')->insertGetId($_list);
    }

}