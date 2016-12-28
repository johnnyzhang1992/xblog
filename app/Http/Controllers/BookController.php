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
        return view('book.index',compact('books'));
    }
    public function create(Request $request){
        $_book = $request->input('_book');
        unset($_book['id']);
        $_book['created_at'] = date('Y-m-d H:i:s');
        $book_id = DB::table('books')->insertGetId($_book);
        if($book_id){
//            return redirect('/book/'.$book_id);
            return back()->with('success','Book创建成功' );
        }else{
//            return redirect('/book');
        }

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