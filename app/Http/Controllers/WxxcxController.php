<?php
/**
 * Created by PhpStorm.
 * User: zq199
 * Date: 2017/6/8
 * Time: 15:49
 */

namespace App\Http\Controllers;
use Iwanli\Wxxcx\Wxxcx;
use Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WxxcxController extends Controller
{
    protected $wxxcx;

    function __construct(Wxxcx $wxxcx)
    {
        $this->wxxcx = $wxxcx;
    }

    /**
     * 小程序登录获取用户信息
     * @date   2017-05-27T14:37:08+0800
     * @return [type]                   [description]
     */
    public function getWxUserInfo(Request $request)
    {
        //code 在小程序端使用 wx.login 获取
        $code = $request->input('code', '');
        //encryptedData 和 iv 在小程序端使用 wx.getUserInfo 获取
        $encryptedData = $request->input('encryptedData', '');
        $iv = $request->input('iv', '');

        //根据 code 获取用户 session_key 等信息, 返回用户openid 和 session_key
        $userInfo = $this->wxxcx->getLoginInfo($code);

        $systemInfo = $request->input('systemInfo','');
        //获取解密后的用户信息
        $user = json_decode($this->wxxcx->getUserInfo($encryptedData, $iv));
        $_user['name'] = $user->nickName;
        $_user['email'] = $user->openId.'@johnnyzhang.cn';
        $_user['password'] =  bcrypt('123456');
        $_user['avatar'] = $user->avatarUrl;
        $_user['remember_token'] = $user->openId;
        $_user['register_form'] = 'weixin';
        //判断用户是否存在
        $_u = DB::table('users')->where('remember_token','=',$user->openId)->get();
        $user_info = [];
        if(!$_u){
            //用户信息入库
           $user_id =  DB::table('users')->insertGetId($_user);
        }else{
            DB::table('users')->where('remember_token','=',$user->openId)->update(array('meta'=>$systemInfo));
            $user_info['user_id'] = $_u[0]->id;
            $user_info['user_name'] = $_u[0]->name;
            $user_info['signature'] = $_u[0]->description;
            $user_info['address'] = json_decode($_u[0]->address);
        }
        return $user_info;
    }

    /**
     * 小程序微信运动相关函数
     * @return array|string
     *
     */
    public function getWxUserRunData()
    {
        //code 在小程序端使用 wx.login 获取
        $code = request('code', '');
        //encryptedData 和 iv 在小程序端使用 wx.getUserInfo 获取
        $encryptedData = request('encryptedData', '');
        $iv = request('iv', '');
        $id = request('id','');
        //根据 code 获取用户 session_key 等信息, 返回用户openid 和 session_key
        $userInfo = $this->wxxcx->getLoginInfo($code);
        //获取解密后的微信运动信息
        $_runData = $this->wxxcx->getRunData($encryptedData, $iv);
        // 先获取数据库里面的最后一条信息
        // 然后再获取的最新信息对比
        // 把找到的对应数据后面的数据
        // 保存到数据库
        $_old_step = null;
        if($userInfo){
            $open_id = DB::table('users')->where('id','=',$id)->value('remember_token');
            DB::table('sports')->where('remember_token','=',$open_id)->update(array('more_info'=>$_runData,'updated_at'=>date('Y-m-d H:i:s')));
            if ($open_id) {
                //查看是否在数据库里面存在记录
                $_u = DB::table('sports')->where('remember_token','=',$open_id)->value('step');
                $_s = DB::table('sports')->where('remember_token','=',$open_id)->value('more_info');
                $a = json_decode($_u);
                $_new_step = json_decode($_s)->stepInfoList;
                $_new_count = count($_new_step);
                $_old_step = json_decode($_u)->stepInfoList;
                $_old_count = count($_old_step);
                if($_u){
                    //如果库里存在旧记录
                    //更新数据
//                     查看新旧两次数据是否相同
                    if($_new_step[$_new_count-1]->timestamp == $_old_step[$_old_count-1]->timestamp){
                        // 如果两次数据中最后一条数据的时间戳一样
                        // 对比数据是否相同
                        if($_new_step[$_new_count-1]->step !== $_old_step[$_old_count-1]->step){
                            $_old_step[$_old_count-1]->step = $_new_step[$_new_count-1]->step;
                            $a->stepInfoList = $_old_step;
                            DB::table('sports')->where('remember_token','=',$open_id)->update(array('updated_at'=>date('Y-m-d H:i:s'),'step'=>json_encode($a)));
                        }
                        return json_encode($a);
                    }else{

                        // 如果最后一条数据的时间戳不一样
                        // 在新数据中查找是否存在此时间戳{ole_one}
                        $old_last_time = $_old_step[$_old_count-1]->timestamp;
                        $num = -1;
                        foreach ($_new_step as $index=>$_step){
                            if($old_last_time == $_step->timestamp){
                                // 如果存在记录此时的序列
                                $num = $index;
                            }
                        }
                        if($num !== -1){
                            // 将数据导入数据库
                            $_num = 0;
                            // 获取old最后一条时间戳后面的数据
                            foreach ($_new_step as $index=>$_step){
                                if($index > $num ){
                                    $_old_step[$_old_count +$_num]['timestamp'] = $_step->timestamp;
                                    $_old_step[$_old_count +$_num]['step'] = $_step->step;
                                    $_num ++;
                                }
                            }
                            info('-----------step_count:'.count($_old_step).'----------------');
                            $a->stepInfoList = $_old_step;
                            DB::table('sports')->where('remember_token','=',$open_id)->update(array(
                                   'step'=>json_encode($a),'more_info'=>null,'updated_at'=>date("Y-m-d H:i:s")
                            ));
                            info('-----------Done----------------');
                        }
                        return json_encode($a);
                    }

                }else{
                    //如果，库里没有记录，数据入库
                    $_step['user_name'] = DB::table('users')->where('id','=',$id)->value('name');
                    $_step['remember_token'] = $open_id;
                    $_step['step'] = $_runData;
                    DB::table('sports')->insertGetId($_step);
                    return $_runData;
                }
            }
        }
    }

    /**
     * 更新用户昵称
     */
    public function updateName(){
        $id = request('id','');
        $name = request('name','');
        $msg = '';
        if($id && $name){
             DB::table('users')->where('id','=',$id)->update(array('name'=>$name));
             $msg = 'success';
        }else{
            $msg = 'fail';
        }
        return $msg;
    }

    /**
     * 更新用户个性签名
     * @return string
     */
    public function updateSignature(){
        $id = request('id','');
        $signature = request('signature','');
        $msg = '';
        if($id && $signature){
             DB::table('users')->where('id','=',$id)->update(array('description'=>$signature));
             $msg = 'success';
        }else{
            $msg = 'fail';
        }
        return $msg;
    }

    /**
     * 更新用户地址
     * @return string
     */
    public function updateAddress(){
        $id = request('id','');
        $address = request('address','');
        $msg = '';
        if($id && $address){
            DB::table('users')->where('id','=',$id)->update(array('address'=>$address));
            $msg = 'success';
        }else{
            $msg = 'fail';
        }
        return $msg;
    }

    /**
     * 获取阅读的数据
     */
    public function getBook(){
        $books = DB::table('books')
            ->orderBy('id', 'asc')
            ->get();
        if(isset($books) && $books){
            return $books;
        }else{
            $books = '无内容！';
            return $books;
        }
    }
    /**
     * 获取单个书籍的详细信息
     */
    public function getBookDetail(){
        $id = request('id','');
        $book_id = request('book_id','');
        $books = DB::table('books')
            ->where('created_id','=',$id)
            ->where('id','=',$book_id)
            ->get();
        if(isset($books) && $books){
            return $books;
        }else{
            $books = '无内容！';
            return $books;
        }
    }
    /**
     * 添加新书
     */
    public function createBook(){
        $_id = request('id','');
        $_book['book_name'] = request('book_name');
        $_book['book_author'] = request('book_author');
        $_book['douban_id'] = request('douban_id');
        $_book['tag'] = '小说';
        $_book['content'] = request('content');
        $_book['cover_image'] = request('cover_image');
        $_book['year'] = date('Y');
        $_book['status'] = 'finish';
        $_book['created_at'] = $_id;
        $_book['created_at'] = date('Y-m-d H:i:s');
        $_book['updated_at'] = date('Y-m-d H:i:s');
        $book_id = DB::table('books')->insertGetId($_book);
        $configurations['configurable_id'] = $book_id;
        $configurations['configurable_type'] = 'App\Book';
        $configurations['config']['comment_type'] ='default';
        $configurations['config']['comment_info'] = 'default';
        $configurations['config'] = json_encode($configurations['config']);
        DB::table('configurations')->insert($configurations);
        if($book_id){
            $msg = 'success';

        }else{
            $msg = 'fail';
        }
        return $msg;
    }
//    public function getRunData($encryptedData, $iv){
//        $pc = new WXBizDataCrypt($this->appId, $this->sessionKey);
//        $decodeData = "";
//        $errCode = $pc->decryptData($encryptedData, $iv, $decodeData);
//
//        if ($errCode !=0 ) {
//            return [
//                'code' => $errCode,
//                'message' => 'encryptedData 解密失败'
//            ];
//        }
//        return $decodeData;
//    }
}
