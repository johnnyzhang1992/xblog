<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TravelController extends Controller
{
    protected $postRepository;

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
    }

    public function index()
    {
        return view('travel.index');
    }
    public function get_data(){
        $_data = DB::table('travel')
            ->get();
        return json_encode($_data);
    }
    public function detail(Request $request,$id){
        if($id){
            $_data = DB::table('travel')
                ->where('id','=',$id)
                ->get();
            return view('travel.detail')->with('poi',$_data[0]);
        }else{
            return redirect('/travel');
        }
    }
    public function detail_update(Request $request,$id){
        $_poi = $request->input('_poi');
        if(isset($id)){
            DB::table('travel')->where('id',$id)->update($_poi);
            return redirect('/travel/poi/'.$id);
        }
    }

}
?>