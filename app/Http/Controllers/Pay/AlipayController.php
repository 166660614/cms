<?php

namespace App\Http\Controllers\Pay;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use GuzzleHttp\Client;
use App\Model\OrderModel;
class AlipayController extends Controller
{
    //


    public $app_id;
    public $gate_way;
    public $notify_url;
    public $snyc_url;
    public $rsaPrivateKeyFilePath = './key/priv.key';
    public $aliPubKey = './key/pub.key';
    public function __construct(){
        $this->app_id = env('ALIPAY_APPID');
        $this->gate_way = env('ALIPAY_GATEWAY');
        $this->notify_url = env('ALIPAY_NOTIFY_URL');
        $this->snyc_url = env('ALIPAY_SNYC_URL');
    }

    /**
     * 请求订单服务 处理订单逻辑
     *
     */


    public function test($order_id)
    {
        $orderInfo=OrderModel::where(['order_id'=>$order_id])->first();
        //判断订单是否已被支付
        if($orderInfo['pay_status']==2){
            die("订单已支付，请勿重复支付");
        }
        //判断订单是否已被删除
        if($orderInfo['is_delete']==2){
            die("订单已被删除，无法支付");
        }
        $bizcont = [
            'subject'           => 'ancsd'. mt_rand(1111,9999).str_random(6),
            'out_trade_no'      =>$orderInfo['order_number'],
            'total_amount'      => $orderInfo['order_amount'],
            'product_code'      => 'QUICK_WAP_WAY',

        ];

        $data = [
            'app_id'   => $this->app_id,
            'method'   => 'alipay.trade.wap.pay',
            'format'   => 'JSON',
            'charset'   => 'utf-8',
            'sign_type'   => 'RSA2',
            'timestamp'   => date('Y-m-d H:i:s'),
            'version'   => '1.0',
            'notify_url'   => $this->notify_url,
            'return_url' => $this->snyc_url,
            'biz_content'   => json_encode($bizcont),
        ];

        $sign = $this->rsaSign($data);
        $data['sign'] = $sign;
        $param_str = '?';
        foreach($data as $k=>$v){
            $param_str .= $k.'='.urlencode($v) . '&';
        }
        $url = rtrim($param_str,'&');
        $url = $this->gate_way . $url;
        header("Location:".$url);
    }


    public function rsaSign($params) {
        return $this->sign($this->getSignContent($params));
    }

    protected function sign($data) {
        $priKey = file_get_contents($this->rsaPrivateKeyFilePath);
        $res = openssl_get_privatekey($priKey);
        ($res) or die('您使用的私钥格式错误，请检查RSA私钥配置');
        openssl_sign($data, $sign, $res, OPENSSL_ALGO_SHA256);
        if(!$this->checkEmpty($this->rsaPrivateKeyFilePath)){
            openssl_free_key($res);
        }
        $sign = base64_encode($sign);
        return $sign;
    }


    public function getSignContent($params) {
        ksort($params);
        $stringToBeSigned = "";
        $i = 0;
        foreach ($params as $k => $v) {
            if (false === $this->checkEmpty($v) && "@" != substr($v, 0, 1)) {

                // 转换成目标字符集
                $v = $this->characet($v, 'UTF-8');
                if ($i == 0) {
                    $stringToBeSigned .= "$k" . "=" . "$v";
                } else {
                    $stringToBeSigned .= "&" . "$k" . "=" . "$v";
                }
                $i++;
            }
        }

        unset ($k, $v);
        return $stringToBeSigned;
    }

    protected function checkEmpty($value) {
        if (!isset($value))
            return true;
        if ($value === null)
            return true;
        if (trim($value) === "")
            return true;

        return false;
    }


    /**
     * 转换字符集编码
     * @param $data
     * @param $targetCharset
     * @return string
     */
    function characet($data, $targetCharset) {

        if (!empty($data)) {
            $fileType = 'UTF-8';
            if (strcasecmp($fileType, $targetCharset) != 0) {
                $data = mb_convert_encoding($data, $targetCharset, $fileType);
            }
        }


        return $data;
    }
    public function  snyc(){
       //print_r($_GET);exit;
       //验签 支付宝的公钥
        if(!$this->verify($_GET)){
            echo "交易失败";
        }
        echo "交易成功";
    }
    public function notify()
    {
        $data = json_encode($_POST);
        $log_str = '>>>> '.date('Y-m-d H:i:s') . $data . "<<<<\n\n";
        //记录日志
        file_put_contents('logs/alipay.log',$log_str,FILE_APPEND);
        //
        $res = $this->verify($_POST);
        file_put_contents('logs/alipay.log',$res,FILE_APPEND);
        $log_str = '>>>> ' . date('Y-m-d H:i:s');
        if($res === false){
            //记录日志 验签失败
            $log_str .= " Sign Failed!<<<<< \n\n";
            file_put_contents('logs/alipay.log',$log_str,FILE_APPEND);
        }else{

            $log_str .= " Sign OK!<<<<< \n\n";
            file_put_contents('logs/alipay.log',$log_str,FILE_APPEND);
        }



        //验证订单交易状态
        if($_POST['trade_status']=='TRADE_SUCCESS'){
            //更新订单状态
            $order_number = $_POST['out_trade_no'];     //商户订单号
            $info = [
                'pay_status'        => 2,       //支付状态  0未支付 1已支付
                'order_amount'    => $_POST['total_amount'] * 100,    //支付金额
                'pay_time'      => strtotime($_POST['gmt_payment']), //支付时间
                'plat_oid'      => $_POST['trade_no'],      //支付宝订单号
                'order_status' => 3,
                'plat'          => 1,      //平台编号 1支付宝 2微信 3第三方
            ];
            //file_put_contents('logs/alipay.log',$info.'\n\n',FILE_APPEND);
            $res2=OrderModel::where(['order_number'=>$order_number])->update($info);
            //file_put_contents('logs/alipay.log',$res2.'\n\n',FILE_APPEND);

        }
        //处理订单逻辑
        //$this->dealOrder($_POST);
        echo 'success';
    }
    public function verify($params){
        $sign = $params['sign'];
        $params['sign_type'] = null;
        $params['sign'] = null;
        //读取公钥文件
        $pubKey = file_get_contents($this->aliPubKey);
        $pubKey = "-----BEGIN PUBLIC KEY-----\n" .
            wordwrap($pubKey, 64, "\n", true) .
            "\n-----END PUBLIC KEY-----";
        //转换为openssl格式密钥
        $res = openssl_get_publickey($pubKey);
        ($res) or die('支付宝RSA公钥错误。请检查公钥文件格式是否正确');
        //调用openssl内置方法验签，返回bool值

        $result = (openssl_verify($this->getSignContent($params), base64_decode($sign), $res, OPENSSL_ALGO_SHA256)===1);
        openssl_free_key($res);

        return $result;

    }
}
