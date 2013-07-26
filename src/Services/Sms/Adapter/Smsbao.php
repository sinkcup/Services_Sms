<?php
/**
 * Adapter for Services_Sms 短信宝（smsbao.com）短信通道
 *
 */

require_once dirname(__FILE__) . '/../Adapter.php';

class Services_Sms_Adapter_Smsbao extends Services_Sms_Adapter
{
    protected $conf = array(
        'u' => '',
        'p' => '',
        'apiUriPrefix' => 'http://smsbao.com/',
        'sign' => '【公司名】',
    );

    public function __construct($conf=array())
    {
        parent::__construct($conf);
    }
    
    public function getRemain()
    {
        $data = array(
            'u' => $this->conf['u'],
            'p' => md5($this->conf['p']),
        );

        $http = new HTTP_Request2($this->conf['apiUriPrefix'] . 'query?' . http_build_query($data), HTTP_Request2::METHOD_GET);
        $r = $http->send()->getBody();

        $tmp = explode("\n", $r);
        if($tmp[0] != 0) {
            throw new Services_Sms_Exception($r);
        }
        $tmp2 = explode(',', $tmp[1]);
        return intval($tmp2[1]);
    }


    public function send($mobile, $content)
    {
        $data = array(
            'u' => $this->conf['u'],
            'p' => md5($this->conf['p']),
            'm' => $mobile,
            'c'=>$content . $this->conf['sign'],
        );

        $http = new HTTP_Request2($this->conf['apiUriPrefix'] . 'sms', HTTP_Request2::METHOD_POST);
        $http->addPostParameter($data);
        $r = $http->send()->getBody();

        if($r != 0) {
            throw new Services_Sms_Exception($r);
        }
        return true;         
    }
}
?>
