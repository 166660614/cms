<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/3 0003
 * Time: 17:05
 */
namespace App\Http\Controllers\Users;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Info;
class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //注册
    public function register(){
        return view('users.reg');
        return view('layouts.bst');
    }
    public function doRegister(Request $request){
        $name=$request->input('u_name');
        $pwd=$request->input('u_pwd');
        $email=$request->input('u_email');
        $data=[
            'name'=>$name,
            'age'=>$request->input('u_age'),
            'email'=>$email,
            'pwd'=>password_hash($pwd,PASSWORD_BCRYPT),
            'reg_time'=>time(),
        ];
        $u_name=Info::where(['name'=>$name])->first();
        if(empty($name)){
            die('用户名不能为空');
        }
        if(empty($pwd)){
            die('密码不能为空');
        }
        if(empty($email)){
            die('邮箱不能为空');
        }
        if(!empty($u_name)){
            echo '该用户名已被注册';
            header('refresh:1,url=/usersregister');
            exit;
        }
        $res = Info::insertGetId($data);
        //var_dump($res);
        if($res){
            setcookie('name',$name,time()+3600,'/','laravel.com',false,true);
            $request->session()->put('user_id',$res);
            header('refresh:3,url=/users/center');
            echo "注册成功";
        }else{
            echo "注册失败";
        }
    }
    //登录
    public function login(){
        return view('users.login');
    }
    public function doLogin(Request $request){
        $pwd=$request->input('u_pwd');
        $name=$request->input('u_name');
        $data=[
            'name'=>$name,
        ];
        $res=Info::where($data)->first();
        if($res){
            if(password_verify($pwd,$res->pwd)){
                $token=substr(md5(time().mt_rand(1,99999)),10,10);
                setcookie('token',$token,time()+86400,'/','laravel.com',false,true);
                $request->session()->put('name',$name);
                $request->session()->put('user_id',$res->id);
                $request->session()->put('u_token',$token);
                header('refresh:2;url=/users/center');
                echo "登陆成功,正在跳转";
            }else{
                echo"账号或密码错误";
            }
        }else{
            die("该用户不存在");
        }
    }
    //首页
    public function center(Request $request){
        if(!empty($_COOKIE['token'])){
            if($request->session()->get('u_token')!=$_COOKIE['token']){
                die('非法请求');
            }
        }
        return view('users.center');
    }
    //退出
    public function loginout(Request $request){
        $request->session()->pull('user_id',null);
        echo "正在退出，请稍后";
        header('refresh:1;url=/users/login');
    }
}
