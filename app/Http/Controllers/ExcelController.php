<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Excel;

class ExcelController extends Controller
{
    //
    //Excel文件导出功能 By Laravel学院
    public function export(){
        $cellData = [
            ['学号','姓名','成绩'],
            ['10001','AAAAA','99'],
            ['10002','BBBBB','92'],
            ['10003','CCCCC','95'],
            ['10004','DDDDD','89'],
            ['10005','EEEEE','96'],
        ];
        Excel::create('学生成绩',function($excel) use ($cellData){
            $excel->sheet('score', function($sheet) use ($cellData){
                $sheet->rows($cellData);
            });
        })->export('xls');
    }
    public function books(){
        $_students = DB::table('books')->get();
        $ret = [['id','book_name','book_author','douban_id','content','douban_url','kindle_url',
            'tag','cover_image','year','view_count','status','created_at','updated_at']];
        $_excel = [];
        foreach ($_students as $student ){
            $_excel = [
                $student->id,
                $student->book_name,
                $student->book_author,
                $student->douban_id,
                $student->content,
                $student->douban_url,
                $student->kindle_url,
                $student->tag,
                $student->cover_image,
                $student->year,
                $student->view_count,
                $student->status,
                $student->created_at,
                $student->updated_at,
            ];
            $ret[] = $_excel;
        }

        Excel::create('books',function($excel) use ($ret){
            $excel->sheet('score', function($sheet) use ($ret){
                $sheet->rows($ret);
            });
        })->export('csv');
    }
    public function categories(){
        $_students = DB::table('categories')->get();
        $ret = [['id','created_at','updated_at','name']];
        $_excel = [];
        foreach ($_students as $student ){
            $_excel = [
                $student->id,
                $student->created_at,
                $student->updated_at,
                $student->name
            ];
            $ret[] = $_excel;
        }

        Excel::create('categories',function($excel) use ($ret){
            $excel->sheet('score', function($sheet) use ($ret){
                $sheet->rows($ret);
            });
        })->export('csv');
    }
    public function comments(){
        $_students = DB::table('comments')->get();
        $ret = [['id','user_id','commentable_id','content','html_content','commentable_type','username',
            'email','deleted_at','created_at','updated_at']];
        $_excel = [];
        foreach ($_students as $student ){
            $_excel = [
                $student->id,
                $student->user_id,
                $student->commentable_id,
                $student->content,
                $student->html_content,
                $student->commentable_type,
                $student->username,
                $student->email,
                $student->deleted_at,
                $student->created_at,
                $student->updated_at,
            ];
            $ret[] = $_excel;
        }

        Excel::create('comments',function($excel) use ($ret){
            $excel->sheet('score', function($sheet) use ($ret){
                $sheet->rows($ret);
            });
        })->export('csv');
    }
    public function configurations(){
        $_students = DB::table('configurations')->get();
        $ret = [['id','configurable_id','configurable_type','config']];
        $_excel = [];
        foreach ($_students as $student ){
            $_excel = [
                $student->id,
                $student->configurable_id,
                $student->configurable_type,
                $student->config
            ];
            $ret[] = $_excel;
        }

        Excel::create('configurable',function($excel) use ($ret){
            $excel->sheet('score', function($sheet) use ($ret){
                $sheet->rows($ret);
            });
        })->export('csv');

    }
    public function files(){
        $_students = DB::table('files')->get();
        $ret = [['id','name','key','type','size','from','created_at','updated_at']];
        $_excel = [];
        foreach ($_students as $student ){
            $_excel = [
                $student->id,
                $student->name,
                $student->key,
                $student->type,
                $student->size,
                $student->from,
                $student->created_at,
                $student->updated_at
            ];
            $ret[] = $_excel;
        }

        Excel::create('files',function($excel) use ($ret){
            $excel->sheet('score', function($sheet) use ($ret){
                $sheet->rows($ret);
            });
        })->export('csv');

    }
    public function maps(){
        $_students = DB::table('maps')->get();
        $ret = [['id','key','tag','value','meta']];
        $_excel = [];
        foreach ($_students as $student ){
            $_excel = [
                $student->id,
                $student->key,
                $student->tag,
                $student->value,
                $student->meta,
            ];
            $ret[] = $_excel;
        }

        Excel::create('maps',function($excel) use ($ret){
            $excel->sheet('score', function($sheet) use ($ret){
                $sheet->rows($ret);
            });
        })->export('csv');

    }
    public function pages(){
        $_students = DB::table('pages')->get();
        $ret = [['id','created_at','updated_at','name','display_name','content','html_content']];
        $_excel = [];
        foreach ($_students as $student ){
            $_excel = [
                $student->id,
                $student->created_at,
                $student->updated_at,
                $student->name,
                $student->display_name,
                $student->content,
                $student->html_content,
            ];
            $ret[] = $_excel;
        }

        Excel::create('pages',function($excel) use ($ret){
            $excel->sheet('score', function($sheet) use ($ret){
                $sheet->rows($ret);
            });
        })->export('csv');

    }
    public function pois(){
        $_students = DB::table('pois')->get();
        $ret = [['id','lat','lng','poi_name','tag','address','cover_image','description','view_count',
            'status','created_at','updated_at']];
        $_excel = [];
        foreach ($_students as $student ){
            $_excel = [
                $student->id,
                $student->lat,
                $student->lng,
                $student->poi_name,
                $student->tag,
                $student->address,
                $student->cover_image,
                $student->description,
                $student->view_count,
                $student->status,
                $student->created_at,
                $student->update_at,
            ];
            $ret[] = $_excel;
        }

        Excel::create('pois',function($excel) use ($ret){
            $excel->sheet('score', function($sheet) use ($ret){
                $sheet->rows($ret);
            });
        })->export('csv');
    }
    public function posts(){
        $_students = DB::table('posts')->get();
        $ret = [['id','user_id','category_id','type','title','description','slug','content','html_content',
            'view_count', 'status','created_at','updated_at','published_at','deleted_at']];
        $_excel = [];
        foreach ($_students as $student ){
            $_excel = [
                $student->id,
                $student->user_id,
                $student->category_id,
                $student->type,
                $student->title,
                $student->description,
                $student->slug,
                $student->content,
                $student->html_content,
                $student->view_count,
                $student->status,
                $student->created_at,
                $student->updated_at,
                $student->published_at,
                $student->deleted_at,
            ];
            $ret[] = $_excel;
        }

        Excel::create('posts',function($excel) use ($ret){
            $excel->sheet('score', function($sheet) use ($ret){
                $sheet->rows($ret);
            });
        })->export('csv');
    }
    public function post_tag(){
        $_students = DB::table('post_tag')->get();
        $ret = [['post_id','tag_id']];
        $_excel = [];
        foreach ($_students as $student ){
            $_excel = [
                $student->post_id,
                $student->tag_id,
            ];
            $ret[] = $_excel;
        }

        Excel::create('post_tag',function($excel) use ($ret){
            $excel->sheet('score', function($sheet) use ($ret){
                $sheet->rows($ret);
            });
        })->export('csv');

    }
    public function sports(){
        $_students = DB::table('sports')->get();
        $ret = [['id','user_name','remember_token','step','more_info','created_at','updated_at']];
        $_excel = [];
        foreach ($_students as $student ){
            $_excel = [
                $student->id,
                $student->user_name,
                $student->remember_token,
                $student->step,
                $student->more_info,
                $student->created_at,
                $student->updated_at
            ];
            $ret[] = $_excel;
        }

        Excel::create('sports',function($excel) use ($ret){
            $excel->sheet('score', function($sheet) use ($ret){
                $sheet->rows($ret);
            });
        })->export('csv');

    }
    public function tags(){
        $_students = DB::table('tags')->get();
        $ret = [['id','created_at','updated_at','name']];
        $_excel = [];
        foreach ($_students as $student ){
            $_excel = [
                $student->id,
                $student->created_at,
                $student->updated_at,
                $student->name
            ];
            $ret[] = $_excel;
        }

        Excel::create('tags',function($excel) use ($ret){
            $excel->sheet('score', function($sheet) use ($ret){
                $sheet->rows($ret);
            });
        })->export('csv');
    }
    public function travel(){
        $_students = DB::table('travel')->get();
        $ret = [['id','lat','lng','poi_name','tag','address','cover_image','description','view_count',
            'status','created_at','updated_at']];
        $_excel = [];
        foreach ($_students as $student ){
            $_excel = [
                $student->id,
                $student->lat,
                $student->lng,
                $student->poi_name,
                $student->tag,
                $student->address,
                $student->cover_image,
                $student->description,
                $student->view_count,
                $student->status,
                $student->created_at,
                $student->update_at,
            ];
            $ret[] = $_excel;
        }

        Excel::create('travel',function($excel) use ($ret){
            $excel->sheet('score', function($sheet) use ($ret){
                $sheet->rows($ret);
            });
        })->export('csv');
    }
    public function travel_files(){
        $_students = DB::table('travel_files')->get();
        $ret = [['id','poi_id','user_id','name','uri','type','size','created_at','updated_at']];
        $_excel = [];
        foreach ($_students as $student ){
            $_excel = [
                $student->id,
                $student->poi_id,
                $student->user_id,
                $student->name,
                $student->uri,
                $student->type,
                $student->size,
                $student->create_time,
                $student->update_at
            ];
            $ret[] = $_excel;
        }

        Excel::create('travel_files',function($excel) use ($ret){
            $excel->sheet('score', function($sheet) use ($ret){
                $sheet->rows($ret);
            });
        })->export('csv');

    }
    public function users(){
        $_students = DB::table('users')->get();
        $ret = [['id','name','email','password','register_from','github_id','github_name',
            'website','real_name','description','meta','avatar','profile_image','remember_token',
            'created_at','updated_at']];
        $_excel = [];
        foreach ($_students as $student ){
            $_excel = [
                $student->id,
                $student->name,
                $student->email,
                $student->password,
                $student->register_from,
                $student->github_id,
                $student->github_name,
                $student->website,
                $student->real_name,
                $student->description,
                $student->meta,
                $student->avatar,
                $student->profile_image,
                $student->remember_token,
                $student->created_at,
                $student->updated_at
            ];
            $ret[] = $_excel;
        }

        Excel::create('users',function($excel) use ($ret){
            $excel->sheet('score', function($sheet) use ($ret){
                $sheet->rows($ret);
            });
        })->export('csv');

    }
}