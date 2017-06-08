<?php

return array(
	/*
	 * 小程序APPID
	 */
    'appid' => 'wx68ebe78cca4dc17c',
    /*
     * 小程序Secret
     */
    'secret' => '031a97d63a3ea2f5e62640c1d04608d6',
    /*
     * 小程序登录凭证 code 获取 session_key 和 openid 地址，不需要改动
     */
    'code2session_url' => 'https://api.weixin.qq.com/sns/jscode2session?appid=%s&secret=%s&js_code=%s&grant_type=authorization_code'
);
