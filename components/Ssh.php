<?php

namespace components;

use application\App;

/**
 * Class for working with Ssh connection
 *
 * @link http://php.net/manual/ru/ref.ssh2.php
 *
 * @package components
 */
class Ssh
{

    /**
     * Config params
     *
     * @var null|\stdClass
     */
    private $_params = null;

    /**
     * Session object
     *
     * @var resource
     */
    private $_connection = null;

    /**
     * Ssh constructor.
     *
     * @param string $sshConnectionName Name of SSH connection
     */
    public function __construct($sshConnectionName)
    {
        if (!$sshConnectionName) {
            $sshConnectionName = App::web()->config->ssh->active;
        }

        $this
            ->_setParams($sshConnectionName)
            ->_setConnection();
    }

    /**
     * Sets connection params
     *
     * @param string $sshConnectionName Name of SSH connection
     *
     * @return Ssh
     *
     * @throws Exception
     */
    private function _setParams($sshConnectionName)
    {
        if (empty(App::web()->config->ssh->list->$sshConnectionName)) {
            Logger::log("Unable to find params for server {$sshConnectionName}", Logger::LEVEL_ERROR, "ssh.params.set");
            throw new Exception("Unable to find params for server");
        }

        $this->_params = App::web()->config->ssh->list->$sshConnectionName;

        return $this;
    }

    /**
     * Sets connection
     *
     * @return Ssh
     *
     * @throws Exception
     */
    private function _setConnection()
    {
        $this->_connection = ssh2_connect($this->_params->host, $this->_params->port, ['hostkey'=>'ssh-rsa']);
        if (!$this->_connection) {
            Logger::log(
                "SSH connection failed. Host: {$this->_params->host}; Port: {$this->_params->port}",
                Logger::LEVEL_ERROR,
                "ssh.params.set"
            );
            throw new Exception("SSH connection failed");
        }

        if (
            !ssh2_auth_pubkey_file(
                $this->_connection,
                $this->_params->username,
                $this->_params->publicKeyPath,
                $this->_params->privateKeyPath,
                $this->_params->passPhrase
            )
        ) {
            Logger::log(
                "SSH connection failed. " .
                "Username: $this->_params->username}; " .
                "PublicKeyPath: $this->_params->publicKeyPath}; " .
                "PrivateKeyPath: $this->_params->privateKeyPath}; " .
                "PassPhrase: {$this->_params->passPhrase}",
                Logger::LEVEL_ERROR,
                "ssh.connection.set"
            );
            throw new Exception("Unable to connect to server");
        }

        return $this;
    }

    /**
     * Sens a file
     *
     * @param string $localFilePath
     * @param string $remoteFilePath
     *
     * @return bool
     */
    public function sendFile($localFilePath, $remoteFilePath)
    {
        return ssh2_scp_send($this->_connection, $localFilePath, $remoteFilePath, 0777);
    }

    /**
     * Removes file
     *
     * @param string $filePath
     *
     * @return bool
     */
    public function deleteFile($filePath)
    {
        return ssh2_sftp_unlink(ssh2_sftp($this->_connection), $filePath);
    }

    /**
     * Creates directory
     *
     * @param string $dirPath
     *
     * @return bool
     */
    public function createDir($dirPath)
    {
        return ssh2_sftp_mkdir(ssh2_sftp($this->_connection), $dirPath, 0777);
    }

    /**
     * Removes directory
     *
     * @param string $dirPath
     *
     * @return bool
     */
    public function deleteDir($dirPath)
    {
        return ssh2_sftp_rmdir(ssh2_sftp($this->_connection), $dirPath);
    }
}