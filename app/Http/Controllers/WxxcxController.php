<?php
/**
 * Created by PhpStorm.
 * User: zq199
 * Date: 2017/6/8
 * Time: 15:49
 */

namespace App\Http\Controllers;
use Iwanli\Wxxcx\Wxxcx;
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
        $_user['email'] = $user->openId.'@johnnyzhang.com';
        $_user['password'] =  bcrypt('123456');
        $_user['avatar'] = $user->avatarUrl;
        $_user['remember_token'] = $user->openId;
        $_user['register_form'] = 'weixin';
        //判断用户是否存在
        $_u = DB::table('users')->where('remember_token','=',$user->openId)->get();

        if(!$_u){
            //用户信息入库
           $user_id =  DB::table('users')->insertGetId($_user);
        }else{
            DB::table('users')->where('remember_token','=',$user->openId)->update(array('meta'=>$systemInfo));
            $user_id = $_u[0]->id;
        }
        return $user_id;
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
        $_new_step =json_decode($_runData);
        $_new_count = count($_new_step);
        // 先获取数据库里面的最后一条信息
        // 然后再获取的最新信息对比
        // 把找到的对应数据后面的数据
        // 保存到数据库
        if($userInfo){
            $open_id = DB::table('users')->where('id','=',$id)->value('remember_token');
            if ($open_id) {
                //查看是否在数据库里面存在记录
                $_u = DB::table('sports')->where('remember_token','=',$open_id)->value('step');
                if($_u){
                    //如果库里存在旧记录
//                    $_old_step = json_decode($_u)->stepInfoList;
//                    $_old_count = count($_old_step);
//                    //更新数据
//                    $updated_at = date('Y-m-d H:i:s');//更新时间
//                    $old_last_time = $_old_step[$_old_count-1]->timestamp;
//                    $_new_step[$_new_count-1]->timestamp;
                    // 查看新旧两次数据是否相同
//                    if($_new_step[$_new_count-1]->timestamp == $_old_step[$_old_count-1]->timestamp){
//                        // 如果两次数据中最后一条数据的时间戳一样
//                        // 对比数据是否相同
//                        if($_new_step[$_new_count-1]->step !== $_old_step[$_old_count-1]->step){
//                            $_old_step[$_old_count-1]->step = $_new_step[$_new_count-1]->step;
//                            DB::table('sports')->where('remember_token','=',$open_id)->update(array('updated_at'=>$updated_at,'step'=>$_old_step));
//                        }
//                    }else{
//                        // 如果最后一条数据的时间戳不一样
//                        // 在新数据中查找是否存在此时间错{ole_one}
//                        $old_last_time = $_old_step[$_old_count-1]->timestamp;
//                        $num = -1;
//                        for($j=0;$j<$_new_count;$j++){
//                            // 遍历新数据
//                            // 比对时间戳
//                            if($old_last_time == $_new_step[$j]->timestamp){
//                                // 如果存在记录此时的序列
//                                $num = $j+1;
//                            }
//                            break;
//                        }
//                        if($num !== -1){
//                            // 将数据导入数据库
//                            $obj = [];
//                            // 获取old最后一条时间戳后面的数据
//                            for($k=$num;$k<$_new_count;$k++){
//                                $_obj = [];
//                                $_obj['time'] =  $_new_step[$k]->timestamp;
//                                $_obj['step'] = $_new_step[$k]->step;
//                                array($obj,$_obj);
//                            }
//                            array_push($_old_step,$obj);
//                        }
//                    }
                }else{
                    //如果，库里没有记录，数据入库
                    $_step['user_name'] = DB::table('users')->where('id','=',$id)->value('name');
                    $_step['remember_token'] = $open_id;
                    $_step['step'] = $_runData;
                    DB::table('sports')->insertGetId($_step);
                }
            }
        }


        return $_runData;
    }
    public function WxUserRunData(){
        $open_id = DB::table('users')->where('id','=',13)->value('remember_token');

        $_u = DB::table('sports')->where('remember_token','=',$open_id)->value('step');
//        $step = $_u->stepInfoList;
        return $_u;
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
