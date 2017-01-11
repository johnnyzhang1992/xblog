<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\VarDumper\Cloner\Data;
use App\Configuration;

class BookController extends Controller
{

    public function index(){
        $books = DB::table('books')->get();
        if(isset($books) && $books){

        }else{
            $books = '无内容！';
        }
        $books_count = count($books);
        return view('book.index',compact('books','books_count'));
    }
    public function detail(Request $request,$id){
        $_data = DB::table('books')
            ->where('id','=',$id)
            ->get();
        if($_data) {
            $_data[0]->view_count += 1;

            DB::table('books')
                ->where('id', $id)
                ->update([
                    'view_count' => $_data[0]->view_count
                ]);
        }
        $book = $_data[0];
        $configuration['config']['comment_type'] = 'default';
        $configuration['config']['comment_info'] = 'default';
        $config = json_encode($configuration['config']);
        $configurations = DB::table('configurations')
            ->where('configurable_type','=','App\Book')
            ->where('configurable_id','=',$id)
            ->get();
        if(!isset($configurations[0]->id)){
            $conf['configurable_id'] = $id;
            $conf['configurable_type'] ='App\Book';
            $conf['config'] = $config;
            DB::table('configurations')->insertGetId($conf);
        }
        return view('book.detail',compact('book'));

    }
    public function create(Request $request){
        $_book = $request->input('_book');
        unset($_book['id']);
        $_book['created_at'] = date('Y-m-d H:i:s');
        $_book['updated_at'] = date('Y-m-d H:i:s');
        $book_id = DB::table('books')->insertGetId($_book);
        $configurations['configurable_id'] = $book_id;
        $configurations['configurable_type'] = 'App\Book';
        $configurations['config']['comment_type'] =$request['comment_type'];
        $configurations['config']['comment_info'] = $request['comment_info'];
        $configurations['config'] = json_encode($configurations['config']);
        DB::table('configurations')->insert($configurations);
        if($book_id){
            return redirect('/book/'.$book_id);

        }else{
            return back()->with('error','Book创建失败' );
        }
    }
    public  function edit(Request $request,$id){
        $book_id = $id;
        $book = DB::table('books')
            ->where('id','=',$book_id)
            ->get();
        $book = $book[0];
        return view('book.edit',compact('book'));
    }
    public function  update(Request $request,$id){
        $book = $request->input('_book');
        $book['updated_at'] = date('Y-m-d H:i:s');
        $book_id = $id;
        DB::table('books')
            ->where('id','=',$book_id)
            ->update($book);
        $configuration['config']['comment_type'] =$request['comment_type'];
        $configuration['config']['comment_info'] = $request['comment_info'];
        $config = json_encode($configuration['config']);
        $book_update = DB::table('configurations')
            ->where('configurable_type','=','App\Poi')
            ->where('configurable_id','=',$id)
            ->update(array('config'=>$config));
        return redirect('/book/'.$id);
    }

    public function destroy(Request $request,$id){
        DB::table('books')->where('id',$id)->update(['status' => 'delete']);
        return back()->with('success','POi删除成功' );
    }
    public function restore(Request $request,$id){
        DB::table('books')->where('id',$id)->update(['status' => 'active']);
        return back()->with('success','Book恢复状态成功' );
    }
    public function get_side_content(){
        $side_poi = DB::table('books')
            ->where('view_count','>',0)
            ->orderBy('view_count', 'desc')
            ->paginate(5);
        return $side_poi;

    }
}