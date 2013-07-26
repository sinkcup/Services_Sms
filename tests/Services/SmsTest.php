<?php
require_once dirname(__FILE__) . '/../../src/Services/Sms.php';
class SmsTest extends PHPUnit_Framework_TestCase
{
    public function atestSendEtonenet()
    {
        $conf = array(
            'spid' => 'foo',
            'sppassword' => 'bar',
        );
        $c = new Services_Sms('etonenet', $conf);
        $r = $c->send('13800138000', 'Hello!树先生 etonenet');
        $this->assertEquals(true, $r);
    }

    public function testSendSmsbao()
    {
        $conf = array(
            'u' => 'foo',
            'p' => 'bar',
            'sign' => '【公司名】',
        );
        $c = new Services_Sms('smsbao', $conf);
        $r = $c->send('13800138000', 'Hello!树先生 smsbao');
        $this->assertEquals(true, $r);
    }
    
    public function testGetRemainSmsbao()
    {
        $conf = array(
            'u' => 'foo',
            'p' => 'bar',
            'sign' => '【公司名】',
        );
        $c = new Services_Sms('smsbao', $conf);
        $r = $c->getRemain();
        var_dump($r);
        $this->assertStringMatchesFormat('%i', strval($r));
    }

    public function testSendIhuyi()
    {
        $conf = array(
            'sname'        => 'foo',
            'spwd'         => 'bar',
            'sprdid'       => 'asdf',
            'sign'         => '【公司名】',
        );
        $c = new Services_Sms('ihuyi', $conf);
        $r = $c->send('13800138000', 'Hello!树先生 ihuyi');
        $this->assertEquals(true, $r);
    }
    
    public function testGetRemainIhuyi()
    {
        $conf = array(
            'sname'        => 'foo',
            'spwd'         => 'bar',
            'sprdid'       => 'asdf',
            'sign'         => '【公司名】',
        );
        $c = new Services_Sms('ihuyi', $conf);
        $r = $c->getRemain();
        var_dump($r);
        $this->assertStringMatchesFormat('%i', strval($r));
    }
}
?>
