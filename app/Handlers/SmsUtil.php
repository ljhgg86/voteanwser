<?php

namespace App\Handlers;


class SmsUtil {
    /**
     * 创建url
     *
     * @param funAndOperate
     *            请求的功能和操作
     * @return
     */
    function createUrl($funAndOperate)
    {

        $timestamp = date("YmdHis");

        return config('sms.BASE_URL') . $funAndOperate;
    }

    function createSig()
    {
        $timestamp = date("YmdHis");

        // 签名
        $sig = md5(config('sms.ACCOUNT_SID') . config('sms.AUTH_TOKEN') . $timestamp);
        return $sig;
    }

    function createBasicAuthData()
    {
        $timestamp = date("YmdHis");
        // 签名
        $sig = md5(config('sms.ACCOUNT_SID') . config('sms.AUTH_TOKEN') . $timestamp);
        return array("accountSid" => config('sms.ACCOUNT_SID'), "timestamp" => $timestamp, "sig" => $sig, "respDataType"=> "JSON");
    }

    /**
     * 创建请求头
     * @param body
     * @return
     */
    function createHeaders()
    {
        $headers = array('Content-type: ' . config('sms.CONTENT_TYPE'), 'Accept: ' . config('sms.ACCEPT'));

        return $headers;
    }

    /**
     * post请求
     *
     * @param funAndOperate
     *            功能和操作
     * @param body
     *            要post的数据
     * @return
     * @throws IOException
     */
    function post($funAndOperate, $body)
    {

        // 构造请求数据
        $url = $this->createUrl($funAndOperate);
        $headers =$this->createHeaders();

        //echo("url:<br/>" . $url . "\n");
        //echo("<br/><br/>body:<br/>" . json_encode($body));
        //echo("<br/><br/>headers:<br/>");
        //var_dump($headers);

        // 要求post请求的消息体为&拼接的字符串，所以做下面转换
        $fields_string = "";
        foreach ($body as $key => $value) {
            $fields_string .= $key . '=' . $value . '&';
        }
        rtrim($fields_string, '&');

        // 提交请求
        $con = curl_init();
        curl_setopt($con, CURLOPT_URL, $url);
        curl_setopt($con, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($con, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($con, CURLOPT_HEADER, 0);
        curl_setopt($con, CURLOPT_POST, 1);
        curl_setopt($con, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($con, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($con, CURLOPT_POSTFIELDS, $fields_string);
        $result = curl_exec($con);
        curl_close($con);

        return "" . $result;
    }

    function sendSms($phone, $code)
    {
        $funAndOperate = "industrySMS/sendSMS";

        // 参数详述请参考http://miaodiyun.com/https-xinxichaxun.html

         // 生成body
        $body = $this->createBasicAuthData();


        // 在基本认证参数的基础上添加短信内容和发送目标号码的参数
        $body['smsContent'] = "【汕头橄榄台】您的橄榄台投票平台验证码为".$code."，请于2分钟内正确输入，如非本人操作，请忽略此短信。";

         //$body['to'] = '13923996025';
        $body['to'] = $phone;

         // 提交请求
        $result = $this->post($funAndOperate, $body);

        return json_decode($result);
    }

    function sendRewardSms($phone, $redeem_code)
    {
        $funAndOperate = "industrySMS/sendSMS";

        // 参数详述请参考http://miaodiyun.com/https-xinxichaxun.html

         // 生成body
        $body = $this->createBasicAuthData();

        // 在基本认证参数的基础上添加短信内容和发送目标号码的参数
        $body['smsContent'] = "【汕头橄榄台】感谢参加汕头橄榄台“我的世界杯竞猜活动”，请凭此短信验证码".$code."，八个工作日内到长平路18号市体彩中心兑换价值240元的游泳卡一张，逾期无效。";

         //$body['to'] = '13923996025';
        $body['to'] = $phone;

         // 提交请求
        $result = $this->post($funAndOperate, $body);

        return json_decode($result);
    }
}