<?php
/**
 * Base class for adapters
 *
 */

//依赖http://pear.php.net/package/HTTP_Request2
require_once 'HTTP/Request2.php';

require_once dirname(__FILE__) . '/Exception.php';

abstract class Services_Sms_Adapter
{
    protected $conf = array();

    protected function __construct($conf=array())
    {
        $this->conf = array_merge($this->conf, $conf);
    }

    protected function getRemain()
    {
    }

    protected function send($mobile, $content)
    {
    }
}
?>
