<?php

namespace App\Http\Controllers\Weixin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\WxUsersModel;

class WxController extends Controller
{
    public function login(){
        $code=$_GET['code'];
        $token_url='https://api.weixin.qq.com/sns/oauth2/access_token?appid=wxe24f70961302b5a5&secret=0f121743ff20a3a454e4a12aeecef4be&code='.$code.'&grant_type=authorization_code';
        $token_json = file_get_contents($token_url);
        $token_arr = json_decode($token_json,true);
        $access_token = $token_arr['access_token'];
        $openid = $token_arr['openid'];
        //获取用户信息
        $user_info_url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';
        $user_json = file_get_contents($user_info_url);
        $user_arr = json_decode($user_json,true);
        //用户信息存数据库
        $usersWhere=[
            'wx_unionid'=>$user_arr['unionid'],
        ];
        $res=WxUsersModel::where($usersWhere)->first();
        if($res){
            //用户已存在
            $updatedata=[
                'wx_last_login_time'=>time(),
                'wx_nickname'=>$user_arr['nickname'],
                'wx_sex'=>$user_arr['sex'],
                'wx_city'=>$user_arr['city'],
                'wx_province'=>$user_arr['province'],
                'wx_country'=>$user_arr['country'],
                'wx_headimgurl'=>$user_arr['headimgurl'],
                'wx_unionid'=>$user_arr['unionid'],
                'wx_openid'=>$user_arr['openid'],
            ];
            WxUsersModel::where($usersWhere)->update($updatedata);
        }else{
            //用户不存在
            $insertData=[
                'wx_last_login_time'=>time(),
                'wx_nickname'=>$user_arr['nickname'],
                'wx_sex'=>$user_arr['sex'],
                'wx_city'=>$user_arr['city'],
                'wx_province'=>$user_arr['province'],
                'wx_country'=>$user_arr['country'],
                'wx_headimgurl'=>$user_arr['headimgurl'],
                'wx_unionid'=>$user_arr['unionid'],
                'wx_openid'=>$user_arr['openid'],
            ];
            $user_id=WxUsersModel::insertGetId($insertData);
        }
    }
}
