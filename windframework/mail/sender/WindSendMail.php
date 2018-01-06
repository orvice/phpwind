<?php


/**
 * 使用sendmail发送邮件.
 *
 * @author Qian Su <aoxue.1988.su.qian@163.com>
 * @copyright ©2003-2103 phpwind.com
 * @license http://www.windframework.com
 *
 * @version $Id: WindSendMail.php 3904 2013-01-08 07:01:26Z yishuo $
 */
class WindSendMail extends WindModule implements IWindSendMail
{
    /**
     * @var string sendmail命令路径
     */
    private $sendMail = '/usr/sbin/sendmail';

    /**
     * @var string 发送�
     */
    private $sender = '';

    /* (non-PHPdoc)
     * @see IWindSendMail::send()
     */
    public function send($mail, $config = array())
    {
        $this->_init($config);
        $mailCmd = escapeshellcmd($this->sendMail).' -oi '.($this->sender ? '-f '.escapeshellarg($this->sender).' ' : '').'-t';
        $process = popen($mailCmd, 'w');
        if (!$process) {
            throw new WindMailException(
            '[mail.sender.WindSendMail.send] send mail fail,can not open the sender process.');
        }
        fwrite($process, $mail->createHeader());
        fwrite($process, $mail->createBody());

        return pclose($process);
    }

    /**
     * 初始化系统配置.
     *
     * @param array $config
     */
    private function _init($config)
    {
        parent::setConfig($config);
        $this->sender = $this->getConfig('sender', '', '');
        $this->sendMail = $this->getConfig('sendMail', '', '/usr/sbin/sendmail');
    }
}
