<?php

namespace App\Http\Controllers\Weixin;

use function GuzzleHttp\Psr7\str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\WxUsersModel;
use Illuminate\Support\Facades\Redis;

class WxController extends Controller
{
    protected $redis_weixin_access_token = 'str:weixin_access_token';     //微信 access_token
    protected $redis_weixin_jsapi_ticket = 'str:weixin_jsapi_ticket';     //微信 jsapi_ticket
    public function login(Request $request){
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
            'wx_openid'=>$user_arr['openid'],
        ];
        $res=WxUsersModel::where($usersWhere)->first();
        //var_dump($res);exit;
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
            $user_id=$res['user_id'];
            $request->session()->put('user_id',$user_id);
            header('refresh:2;url=/goods/allshow');
        }else{
            //用户不存在
            $insertData=[
                'wx_last_login_time'=>time(),
                'wx_add_time'=>time(),
                'wx_nickname'=>$user_arr['nickname'],
                'wx_sex'=>$user_arr['sex'],
                'wx_city'=>$user_arr['city'],
                'wx_province'=>$user_arr['province'],
                'wx_country'=>$user_arr['country'],
                'wx_headimgurl'=>$user_arr['headimgurl'],
                'wx_unionid'=>$user_arr['unionid'],
                'wx_openid'=>$user_arr['openid'],
            ];
            var_dump($insertData);exit;
            $user_id=WxUsersModel::insertGetId($insertData);
            $request->session()->put('user_id',$user_id);
            header('refresh:2;url=/goods/allshow');
        }
    }
    public function jssdk(){
        $data=[
            'nocestr'=>str_random(10),
            'timestamp'=>time(),
            'appid'=>env('WEIXIN_JSSDK_APPID'),
        ];
        $sign = $this->wxJsConfigSign($data);
        $data['sign'] = $sign;
        return view('weixin.jssdk',$data);
    }
    /*
     * 计算jssdk sign
     */
    public function wxJsConfigSign($param){
        $current_url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];     //当前调用 jsapi的 url
        $ticket=$this->getJsapiTicket();
        $str =  'jsapi_ticket='.$ticket.'&noncestr='.$param['nocestr']. '&timestamp='. $param['timestamp']. '&url='.$current_url;
        $signature=sha1($str);
        return $signature;
    }
    public function getJsapiTicket()
    {

        //是否有缓存
        $ticket = Redis::get($this->redis_weixin_jsapi_ticket);
        if(!$ticket){           // 无缓存 请求接口
            $access_token = '19_h0Fz0b_HWSZR5b-gGIJjqOQ2tqqkwRJa7WTacsxvnlv9xL52oBh2FbSlz7xdJFB5xZaIYq8Q_7bzcPBAfmrznvRbjt_vKrf2d2rPpUetbD8GYAANway_XbFTn9rfFF175nnVD1v73v8Cqz62DRZbAJAHVD';
            $ticket_url = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token='.$access_token.'&type=jsapi';
            $ticket_info = file_get_contents($ticket_url);
            $ticket_arr = json_decode($ticket_info,true);

            if(isset($ticket_arr['ticket'])){
                $ticket = $ticket_arr['ticket'];
                Redis::set($this->redis_weixin_jsapi_ticket,$ticket);
                Redis::setTimeout($this->redis_weixin_jsapi_ticket,3600);       //设置过期时间 3600s
            }
        }
        return $ticket;

    }
    public function getWXAccessToken()
    {

        //获取缓存
        $token = Redis::get($this->redis_weixin_access_token);
        if(!$token){        // 无缓存 请求微信接口
            $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.env('WEIXIN_APPID').'&secret='.env('WEIXIN_APPSECRET');
            $data = json_decode(file_get_contents($url),true);

            //记录缓存
            $token = $data['access_token'];
            Redis::set($this->redis_weixin_access_token,$token);
            Redis::setTimeout($this->redis_weixin_access_token,3600);
        }
        return $token;

    }
}
