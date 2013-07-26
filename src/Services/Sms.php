<?php
/**
 * 发短信
 *
 * @category Services
 * @package  Services_Sms
 * @author   sink <sinkcup@163.com>
 * @license  http://opensource.org/licenses/bsd-license.php New BSD License
 * @link     https://github.com/sinkcup/Services_Sms
 */

require_once dirname(__FILE__) . '/Sms/Adapter/Ihuyi.php';
require_once dirname(__FILE__) . '/Sms/Adapter/Smsbao.php';
require_once dirname(__FILE__) . '/Sms/Adapter/Etonenet.php';

class Services_Sms
{
    protected $adapter;

    /**
     * @param string $gateway 短信服务商，比如etonenet、ihuyi、smsbao
     *
     * @param array $conf 各个短信服务商的配置，比如帐号密码
     */
    public function __construct($gateway, array $conf=array())
    {
        $className = 'Services_Sms_Adapter_' . ucfirst(strtolower($gateway));
        $this->adapter = new $className($conf);
    }

    /**
     * 发短信
     *
     * @return boolean
     */
    public function send($mobile, $content)
    {
        return $this->adapter->send($mobile, $content);
    }
    
    /**
     * 查短信余量
     *
     * @return int
     */
    public function getRemain()
    {
        return $this->adapter->getRemain();
    }

}
?>
