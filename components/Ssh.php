<?php

namespace testS\components;

use testS\applications\App;
use testS\components\exceptions\SshException;

/**
 * Class for working with Ssh connection
 *
 * @link http://php.net/manual/ru/ref.ssh2.php
 *
 * @package testS\components
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
    public function __construct($sshConnectionName = null)
    {
        if (!$sshConnectionName) {
            $sshConnectionName = App::web()->getConfig()->ssh->active;
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
     * @throws SshException
     */
    private function _setParams($sshConnectionName)
    {
        if (empty(App::web()->getConfig()->ssh->list->$sshConnectionName)) {
            throw new SshException(
                "Unable to find parameters for the server: {sshConnectionName}",
                [
                    "sshConnectionName" => $sshConnectionName
                ]
            );
        }

        $this->_params = App::web()->getConfig()->ssh->list->$sshConnectionName;

        return $this;
    }

    /**
     * Sets connection
     *
     * @return Ssh
     *
     * @throws SshException
     */
    private function _setConnection()
    {
        $this->_connection = ssh2_connect($this->_params->host, $this->_params->port, ['hostkey'=>'ssh-rsa']);
        if (!$this->_connection) {
            throw new SshException(
                "SSH connection failed. Host: {host}; Port: {port}",
                [
                    "host" => $this->_params->host,
                    "port" => $this->_params->port
                ]
            );
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
            throw new SshException(
                "Unable to connect to server with parameters:" .
                "Username: {username}; " .
                "PublicKeyPath: {publicKeyPath}; " .
                "PrivateKeyPath: {privateKeyPath}; " .
                "PassPhrase: {passPhrase}",
                [
                    "username"       => $this->_params->username,
                    "publicKeyPath"  => $this->_params->publicKeyPath,
                    "privateKeyPath" => $this->_params->privateKeyPath,
                    "passPhrase"     => $this->_params->passPhrase
                ]
            );
        }

        return $this;
    }

    /**
     * Sens a file
     *
     * @param string $localFilePath
     * @param string $remoteFilePath
     *
     * @throws SshException
     */
    public function sendFile($localFilePath, $remoteFilePath)
    {
        $remotePath = $this->_params->uploadFolder . "/" . $remoteFilePath;
        
        $result = ssh2_scp_send(
            $this->_connection,
            $localFilePath,
            $remotePath,
            0777
        );
        
        if (!$result) {
            throw new SshException(
                "Unable to send the file with localFilePath: {localFilePath} and remotePath: {remotePath}",
                [
                    "localFilePath" => $localFilePath,
                    "remotePath"    => $remotePath,
                ]
            );
        }
    }

    /**
     * Removes file
     *
     * @param string $filePath
     *
     * @throws SshException
     */
    public function deleteFile($filePath)
    {
        $path = $this->_params->uploadFolder . "/" . $filePath;
        
        $result = ssh2_sftp_unlink(ssh2_sftp($this->_connection), $path);
        
        if (!$result) {
            throw new SshException(
                "Unable to delete the file with path: {path}",
                [
                    "path" => $path
                ]
            );
        }
    }

    /**
     * Creates directory
     *
     * @param string $dirPath
     *
     * @throws SshException
     */
    public function createDir($dirPath)
    {
        $path = $this->_params->uploadFolder . "/" . $dirPath;
        
        $result = ssh2_sftp_mkdir(ssh2_sftp($this->_connection), $path, 0777);

        if (!$result) {
            throw new SshException(
                "Unable to create the directory with path: {path}",
                [
                    "path" => $path
                ]
            );
        }
    }

    /**
     * Removes directory
     *
     * @param string $dirPath
     *
     * @throws SshException
     */
    public function deleteDir($dirPath)
    {
        $path = $this->_params->uploadFolder . "/" . $dirPath;
        
        $result = ssh2_sftp_rmdir(ssh2_sftp($this->_connection), $path);

        if (!$result) {
            throw new SshException(
                "Unable to delete the directory with path: {path}",
                [
                    "path" => $path
                ]
            );
        }
    }
}