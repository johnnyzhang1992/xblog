<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\VarDumper\Cloner\Data;
use App\Configuration;

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
    public function poi_count(){
        $count = DB::table('pois')->count();
        return $count;
    }
    public function get_data(){
        $_data = DB::table('pois')
            ->get();
        return json_encode($_data);
    }
    public function detail(Request $request,$id){
        if($id <= $this->poi_count()){
            $_data = DB::table('pois')
                ->where('id','=',$id)
                ->get();
            if($_data) {
                $_data[0]->view_count += 1;

                DB::table('pois')
                    ->where('id', $id)
                    ->update([
                        'view_count' => $_data[0]->view_count
                    ]);
            }
            $img_list = DB::table('travel_files')
                ->where('poi_id','=',$id)
                ->get();
            $poi = $_data[0];
            $configuration['config']['comment_type'] = 'default';
            $configuration['config']['comment_info'] = 'default';
            $config = json_encode($configuration['config']);
            $configurations = DB::table('configurations')
                ->where('configurable_type','=','App\Poi')
                ->where('configurable_id','=',$id)
                ->get();
            if(!isset($configurations[0]->id)){
                $conf['configurable_id'] = $id;
                $conf['configurable_type'] ='App\Poi';
                $conf['config'] = $config;
                DB::table('configurations')->insertGetId($conf);
            }
            $side_poi = $this->get_side_content();
            return view('travel.detail',compact('poi','img_list','side_poi'));
//            return view('travel.detail')->with('poi',$_data[0]);
        }else{
            return redirect('/travel');
        }
    }
    public function edit(Request $request,$id){
        if($id <= $this->poi_count()){
            $_data = DB::table('pois')
                ->where('id','=',$id)
                ->get();
            $configurations = DB::table('configurations')
                ->where('configurable_type','=','App\Poi')
                ->where('configurable_id','=',$_data[0]->id)
                ->get();
            $img_list = DB::table('travel_files')
                ->where('poi_id','=',$id)
                ->get();
            $poi = $_data[0];
            if(isset($configurations->id) && !empty($configurations->id)){
                $configurations = $configurations[0];
                return view('travel.edit',compact('poi','img_list','configurations'));
            }else{
                return view('travel.edit',compact('poi','img_list'));
            }

        }else{
            return redirect('/travel');
        }
    }
    public function detail_update(Request $request,$id){
        $_poi = $request->input('_poi');
        if($id <= $this->poi_count()){
            DB::table('pois')->where('id',$id)->update($_poi);
            $configuration['config']['comment_type'] =$request['comment_type'];
            $configuration['config']['comment_info'] = $request['comment_info'];
            $config = json_encode($configuration['config']);
            $configurations = DB::table('configurations')
                ->where('configurable_type','=','App\Poi')
                ->where('configurable_id','=',$id)
                ->get();
            if(isset($configurations[0]->id)){
                 DB::table('configurations')
                    ->where('configurable_type','=','App\Poi')
                    ->where('configurable_id','=',$id)
                    ->update(array('config'=>$config));
            }else{
                $conf['configurable_id'] = $id;
                $conf['configurable_type'] ='App\Poi';
                $conf['config'] = $config;
                DB::table('configurations')->insertGetId($conf);
            }
            return redirect('/travel/poi/'.$id);
        }else{
            return redirect('/travel');
        }
    }
    public function create(Request $request){
        $_poi = $request->input('_poi');
        unset($_poi['id']);
        $_poi['created_at'] = date('Y-m-d H:i:s');
        $poi_id = DB::table('pois')->insertGetId($_poi);
        if($poi_id){
            return redirect('/travel/poi/'.$poi_id);
        }else{
            return redirect('/travel');
        }

    }
    public function destroy(Request $request,$id){
        DB::table('pois')->where('id',$id)->update(['status' => 'delete']);
        return back()->with('success','POi删除成功' );
    }
    public function restore(Request $request,$id){
        DB::table('pois')->where('id',$id)->update(['status' => 'active']);
        return back()->with('success','POi恢复状态成功' );
    }
    public function get_side_content(){
        $side_poi = DB::table('pois')
            ->where('view_count','>',0)
            ->orderBy('view_count', 'desc')
            ->paginate(5);
        return $side_poi;

    }
}
?>