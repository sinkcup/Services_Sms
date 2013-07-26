<?php
/**
 * Adapter for Services_Sms 互亿无线（ihuyi.com）短信通道
 *
 */

require_once dirname(__FILE__) . '/../Adapter.php';

class Services_Sms_Adapter_Ihuyi extends Services_Sms_Adapter
{
    protected $conf = array(
        'apiUriPrefix' => 'http://60.28.200.150/submitdata/service.asmx',
        'sname'        => '',
        'spwd'         => '',
        'scorpid'      => '',
        'sprdid'       => '',
        'sign'         => '【公司名】',
    );

    public function __construct($conf=array())
    {
        parent::__construct($conf);
    }
    
    public function getRemain()
    {
        $data = array(
            'sname'=>$this->conf['sname'],
            'spwd'=>$this->conf['spwd'],
            'scorpid'=>$this->conf['scorpid'],
            'sprdid'=>$this->conf['sprdid'],
        );

        $http = new HTTP_Request2($this->conf['apiUriPrefix'] . '/Sm_GetRemain?' . http_build_query($data), HTTP_Request2::METHOD_GET);
        $r = $http->send()->getBody();

        $tmp = $this->filter($r);
        if($tmp['State'] != 0) {
            throw new Services_Sms_Exception($r);
        }
        return intval($tmp['Remain']);
    }


    public function send($mobile, $content)
    {
        $data = array(
            'sname'=>$this->conf['sname'],
            'spwd'=>$this->conf['spwd'],
            'scorpid'=>$this->conf['scorpid'],
            'sprdid'=>$this->conf['sprdid'],
            'sdst'=>$mobile,
            'smsg'=>$content . $this->conf['sign']
        );

        $http = new HTTP_Request2($this->conf['apiUriPrefix'] . '/g_Submit', HTTP_Request2::METHOD_POST);
        $http->addPostParameter($data);
        $r = $http->send()->getBody();

        $tmp = $this->filter($r);
        if($tmp['State'] != 0) {
            throw new Services_Sms_Exception($r);
        }
        return true;         
    }

    private function filter($str)
    {
        if (preg_match('/<\?xml\s+.+$/is', $str, $matches)) {
            $xml = simplexml_load_string($matches[0]);
            return get_object_vars($xml);
        }
        throw new Services_Sms_Exception($str);
    }
}
?>
