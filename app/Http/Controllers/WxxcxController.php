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
    public function getWxUserInfo()
    {
        //code 在小程序端使用 wx.login 获取
        $code = request('code', '');
        //encryptedData 和 iv 在小程序端使用 wx.getUserInfo 获取
        $encryptedData = request('encryptedData', '');
        $iv = request('iv', '');

        //根据 code 获取用户 session_key 等信息, 返回用户openid 和 session_key
        $userInfo = $this->wxxcx->getLoginInfo($code);

        //获取解密后的用户信息
        $user = json_decode($this->wxxcx->getUserInfo($encryptedData, $iv));
        $_user['name'] = $user->nickName;
        $_user['email'] = null;
        $_user['password'] =  bcrypt('123456');
        $_user['avatar'] = $user->avatarUrl;
        $_user['remember_token'] = $user->openId;
        $_user['register_form'] = 'weixin';
        //判断用户是否存在
        $_u = DB::table('users')->where('remember_token','=',$user->openId)->get();
        if(!$_u){
            //用户信息入库
            DB::table('users')->insertGetId($_user);
        }
        return $this->wxxcx->getUserInfo($encryptedData, $iv);
    }
}
