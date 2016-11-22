<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Map;
use App\Page;
use App\User;
use DB;
use Illuminate\Http\Request;

class ListController extends Controller{

    /**
     * ListController constructor.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }
    public function index(){
        $info = 'hello world';
        return view('list.index', compact('info'));
    }
}