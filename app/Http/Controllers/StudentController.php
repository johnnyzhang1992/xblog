<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\VarDumper\Cloner\Data;
use App\Configuration;
use Excel;

class StudentController extends Controller
{
    public function  create(Request $request){
        $_student = $request->input('_student');
        $_student['status'] = 'active';
        $_phone = $request->input('_student[phone]');
        if(empty(trim($_phone)) ){
            $_student['phone'] = null;
        }
        $student_id = DB::table('students')->insertGetId($_student);
        if($student_id){
            return back()->with('success','信息添加成功！' );
        }else{
            return back()->with('error','创建失败' );
        }
    }
    public function edit(Request $request){

        $_student = $request->input('_student');
        $_student['status'] = 'active';
        $_id = intval($request->input('id'));
        $_phone = $request->input('_student[phone]');
        print $_phone;
        if($_phone == '' || $_phone == null || $_phone){
            $_student['phone'] = null;
        }
        $students = DB::table('students')
            ->where('id','=',$_id)
            ->update($_student);
        if($students){
            return back()->with('success','信息编辑保存成功！' );
        }else{
            return back()->with('success','信息编辑保存失败！phone:'.$_student['phone'] );
        }
    }

    public function delete(Request $request){
        $_id = intval($request->input('id'));
        $students = DB::table('students')
            ->where('id','=',$_id)
            ->update(array('status'=>'delete'));
        if($students){
            return back()->with('success','删除成功！' );
        }else{
            return back()->with('success','删除失败！' );
        }
    }
    public function restore($id,Request $request){
        $_id = intval($id);
        $students = DB::table('students')
            ->where('id','=',$_id)
            ->update(array('status'=>'active'));
        if($students){
            return back()->with('success','恢复成功！' );
        }else{
            return back()->with('success','恢复失败！' );
        }
    }
    public function excel(){
        $_students = DB::table('students')->where('status','!=','delete')->get();
        $ret = [['ID','姓名','学校','电话','兼职经历']];
        $_excel = [];
        foreach ($_students as $student ){
                $_excel = [
                    $student->id,
                    $student->name,
                    $student->school,
                    $student->phone,
                    $student->experience,
                ];
            $ret[] = $_excel;
        }

        Excel::create('豌豆兼职学生信息表',function($excel) use ($ret){
            $excel->sheet('score', function($sheet) use ($ret){
                $sheet->rows($ret);
            });
        })->export('xls');
    }
}