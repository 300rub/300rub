<?php

namespace ss\application\components\senders;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use ss\application\App;
use ss\application\exceptions\EmailException;

/**
 * Class for working with email
 */
class Email
{

    /**
     * PHPMailer object
     *
     * @var PHPMailer
     */
    private $_mail = null;

    /**
     * Specify main and backup SMTP servers
     *
     * @var string
     */
    private $_host = '';

    /**
     * SMTP username
     *
     * @var string
     */
    private $_username = '';

    /**
     * SMTP password
     *
     * @var string
     */
    private $_password = '';

    /**
     * Enable TLS encryption, `ssl` also accepted
     *
     * @var string
     */
    private $_smtpSecure = '';

    /**
     * TCP port to connect to
     *
     * @var int
     */
    private $_port = 0;

    /**
     * From address
     *
     * @var string
     */
    private $_fromAddress = '';

    /**
     * From name
     *
     * @var string
     */
    private $_fromName = '';

    /**
     * Addresses
     *
     * @var array
     */
    private $_recipients = [];

    /**
     * Reply to list
     *
     * @var array
     */
    private $_replyToList = [];

    /**
     * CC list
     *
     * @var array
     */
    private $_ccList = [];

    /**
     * Attachments
     *
     * @var array
     */
    private $_attachments = [];

    /**
     * Subject
     *
     * @var string
     */
    private $_subject = '';

    /**
     * Body
     *
     * @var string
     */
    private $_body = '';

    /**
     * Email constructor
     */
    public function __construct()
    {
        $this->_mail = new PHPMailer(true);
    }

    /**
     * Sets host
     *
     * @param string $host Host
     *
     * @return Email
     */
    public function setHost($host)
    {
        $this->_host = $host;
        return $this;
    }

    /**
     * Gets Host
     *
     * @return string
     */
    private function _getHost()
    {
        if ($this->_host === '') {
            $this->_host = App::getInstance()
                ->getConfig()
                ->getValue(['email', 'host']);
        }

        return $this->_host;
    }

    /**
     * Sets username
     *
     * @param string $username Username
     *
     * @return Email
     */
    public function setUsername($username)
    {
        $this->_username = $username;
        return $this;
    }

    /**
     * Gets username
     *
     * @return string
     */
    private function _getUsername()
    {
        if ($this->_username === '') {
            $this->_username = App::getInstance()
                ->getConfig()
                ->getValue(['email', 'username']);
        }

        return $this->_username;
    }

    /**
     * Sets password
     *
     * @param string $password Password
     *
     * @return Email
     */
    public function setPassword($password)
    {
        $this->_password = $password;
        return $this;
    }

    /**
     * Gets password
     *
     * @return string
     */
    private function _getPassword()
    {
        if ($this->_password === '') {
            $this->_password = App::getInstance()
                ->getConfig()
                ->getValue(['email', 'password']);
        }

        return $this->_password;
    }

    /**
     * Sets SMTP Secure
     *
     * @param string $smtpSecure Password
     *
     * @return Email
     */
    public function setSmtpSecure($smtpSecure)
    {
        $this->_smtpSecure = $smtpSecure;
        return $this;
    }

    /**
     * Gets SMTP Secure
     *
     * @return string
     */
    private function _getSmtpSecure()
    {
        if ($this->_smtpSecure === '') {
            $this->_smtpSecure = App::getInstance()
                ->getConfig()
                ->getValue(['email', 'smtpSecure']);
        }

        return $this->_smtpSecure;
    }

    /**
     * Sets Port
     *
     * @param int $port Port
     *
     * @return Email
     */
    public function setPort($port)
    {
        $this->_port = $port;
        return $this;
    }

    /**
     * Gets Port
     *
     * @return int
     */
    private function _getPort()
    {
        if ($this->_port === '') {
            $this->_port = App::getInstance()
                ->getConfig()
                ->getValue(['email', 'port']);
        }

        return $this->_port;
    }

    /**
     * Sets From address
     *
     * @param string $fromAddress From address
     *
     * @return Email
     */
    public function setFromAddress($fromAddress)
    {
        $this->_fromAddress = $fromAddress;
        return $this;
    }

    /**
     * Gets From address
     *
     * @return string
     */
    private function _getFromAddress()
    {
        if ($this->_fromAddress === '') {
            $this->_fromAddress = App::getInstance()
                ->getConfig()
                ->getValue(['email', 'fromAddress']);
        }

        return $this->_fromAddress;
    }

    /**
     * Sets From name
     *
     * @param string $fromName From name
     *
     * @return Email
     */
    public function setFromName($fromName)
    {
        $this->_fromName = $fromName;
        return $this;
    }

    /**
     * Gets From name
     *
     * @return string
     */
    private function _getFromName()
    {
        if ($this->_fromName === '') {
            $this->_fromName = App::getInstance()
                ->getConfig()
                ->getValue(['email', 'fromName']);
        }

        return $this->_fromName;
    }

    /**
     * Adds recipient to list
     *
     * @param string $address Address
     * @param string $name    Name
     *
     * @return Email
     */
    public function addRecipient($address, $name = '')
    {
        $this->_recipients[$address] = $name;
        return $this;
    }

    /**
     * Adds reply to list
     *
     * @param string $address Address
     * @param string $name    Name
     *
     * @return Email
     */
    public function addReplyTo($address, $name = '')
    {
        $this->_replyToList[$address] = $name;
        return $this;
    }

    /**
     * Adds CC to list
     *
     * @param string $address Address
     * @param string $name    Name
     *
     * @return Email
     */
    public function addCc($address, $name = '')
    {
        $this->_ccList[$address] = $name;
        return $this;
    }

    /**
     * Adds attachment
     *
     * @param string $path Path
     * @param string $name Name
     *
     * @return Email
     */
    public function addAttachment($path, $name = '')
    {
        $this->_ccList[$path] = $name;
        return $this;
    }

    /**
     * Sets subject
     *
     * @param string $subject Subject
     *
     * @return Email
     */
    public function setSubject($subject)
    {
        $this->_subject = $subject;
        return $this;
    }

    /**
     * Gets subject
     *
     * @return string
     */
    private function _getSubject()
    {
        return $this->_subject;
    }

    /**
     * Sets body
     *
     * @param string $body Body
     *
     * @return Email
     */
    public function setBody($body)
    {
        $this->_body = $body;
        return $this;
    }

    /**
     * Gets body
     *
     * @return string
     */
    private function _getBody()
    {
        return $this->_body;
    }

    /**
     * Sets server settings
     *
     * @return Email
     */
    private function _setServerSetting()
    {
        $this->_mail->SMTPDebug = 0;
        $this->_mail->isSMTP();
        $this->_mail->Host = $this->_getHost();
        $this->_mail->SMTPAuth = true;
        $this->_mail->Username = $this->_getUsername();
        $this->_mail->Password = $this->_getPassword();
        $this->_mail->SMTPSecure = $this->_getSmtpSecure();
        $this->_mail->Port = $this->_getPort();

        return $this;
    }

    /**
     * Sets recipients
     *
     * @return Email
     */
    private function _setRecipients()
    {
        $this->_mail->setFrom(
            $this->_getFromAddress(),
            $this->_getFromName()
        );

        foreach ($this->_recipients as $address => $name) {
            $this->_mail->addAddress($address, $name);
        }

        foreach ($this->_replyToList as $address => $name) {
            $this->_mail->addReplyTo($address, $name);
        }

        foreach ($this->_ccList as $address => $name) {
            $this->_mail->addCC($address, $name);
        }

        return $this;
    }

    /**
     * Sets attachments
     *
     * @return Email
     */
    private function _setAttachments()
    {
        foreach ($this->_attachments as $path => $name) {
            $this->_mail->addAttachment($path, $name);
        }

        return $this;
    }

    /**
     * Sets content
     *
     * @return Email
     */
    private function _setContent()
    {
        $this->_mail->isHTML(true);
        $this->_mail->Subject = $this->_getSubject();
        $this->_mail->Body = $this->_getBody();
        $this->_mail->AltBody = strip_tags($this->_getBody());

        return $this;
    }

    /**
     * Sends email
     *
     * @return void
     *
     * @throws Exception
     * @throws \Exception
     */
    public function send()
    {
        try {
            $this
                ->_setServerSetting()
                ->_setRecipients()
                ->_setAttachments()
                ->_setContent();

            $this->_mail->send();

            App::getInstance()->getLogger()->info(
                sprintf(
                    'Email has been successfully sent' .
                    'Data: [%s]',
                    $this->_generateLogData()
                ),
                'email'
            );
        } catch (Exception $e) {
            throw new EmailException(
                sprintf(
                    'Message could not be sent. Mailer Error: [%s]' .
                    'Data: [%s]',
                    $this->_mail->ErrorInfo,
                    $this->_generateLogData()
                )
            );
        } catch (\Exception $e) {
            throw new EmailException(
                sprintf(
                    'An error occurred while sending email' .
                    'Error: [%s], file: [%s], line: [%s]' .
                    'Data: [%s]',
                    $e->getMessage(),
                    $e->getFile(),
                    $e->getLine(),
                    $this->_generateLogData()
                )
            );
        }
    }

    /**
     * Generates log data
     *
     * @return string
     */
    private function _generateLogData()
    {
        return sprintf(
            'Host: [%s], ' .
            'Username: [%s], ' .
            'Password: [%s], ' .
            'SMTP Secure: [%s], ' .
            'Port: [%s], ' .
            'From address: [%s], ' .
            'From name: [%s], ' .
            'Recipients: [%s], ' .
            'Reply To: [%s], ' .
            'CC: [%s], ' .
            'Attachments: [%s], ' .
            'Subject: [%s], ' .
            'Body: [%s]',
            $this->_host,
            $this->_username,
            $this->_password,
            $this->_smtpSecure,
            $this->_port,
            $this->_fromAddress,
            $this->_fromName,
            json_encode($this->_recipients),
            json_encode($this->_replyToList),
            json_encode($this->_ccList),
            json_encode($this->_attachments),
            $this->_subject,
            $this->_body
        );
    }
}
