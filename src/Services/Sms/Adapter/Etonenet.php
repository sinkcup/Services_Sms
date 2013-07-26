<?php
/**
 * Adapter for Services_Sms 移通网络（etonenet.com）短信通道
 *
 */

require_once dirname(__FILE__) . '/../Adapter.php';

class Services_Sms_Adapter_Etonenet extends Services_Sms_Adapter
{
    protected $conf = array(
        'spid' => '',
        'sppassword' => '',
        'apiUriPrefix' => 'http://esms4.etonenet.com/', //esms会返回100错误，而esms4电信通道可以
    );

    public function __construct($conf=array())
    {
        parent::__construct($conf);
    }
    
    public function getRemain()
    {
        //todo 没找到接口
        return 0;
    }

    public function send($mobile, $content)
    {
        //需要国家码
        if(stripos($mobile, '86') !== 0) {
            $mobile = '86' . $mobile;
        }
        //移通 会在短信里自动加上签名【xxx】，所以不用自己加了。
        $data = array(
            'command' => 'MT_REQUEST',
            'spid' => $this->conf['spid'],
            'sppassword' => $this->conf['sppassword'],
            'da' => $mobile,
            'dc' => '8', //UTF-16BE
            'sm' => bin2hex(mb_convert_encoding($content, 'UTF-16BE', 'UTF-8')),
        );

        $http = new HTTP_Request2($this->conf['apiUriPrefix'] . 'sms/mt', HTTP_Request2::METHOD_POST);
        $http->addPostParameter($data);
        $r = $http->send()->getBody();

        parse_str($r, $tmp);
        if($tmp['mterrcode'] != '000') {
            throw new Services_Sms_Exception($r);
        }
        return true;         
    }
}
?>
