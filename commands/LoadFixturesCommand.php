<?php

namespace testS\commands;

use testS\application\App;
use testS\application\components\Language;
use testS\commands\_abstract\AbstractCommand;
use testS\models\_abstract\AbstractModel;

/**
 * Load fixtures command
 */
class LoadFixturesCommand extends AbstractCommand
{

    /**
     * File Data
     *
     * @var array
     */
    private $_fileData = [];

    /**
     * Order of fixtures loading
     *
     * @var string[]
     */
    private $_fixtureOrder = [
        'user'
            => '\\testS\\models\\user\\UserModel',
        'userSession'
            => '\\testS\\models\\user\\UserSessionModel',
        'text'
            => '\\testS\\models\\blocks\\text\\TextModel',
        'textInstance'
            => '\\testS\\models\\blocks\\text\\TextInstanceModel',
        'image'
            => '\\testS\\models\\blocks\\image\\ImageModel',
        'imageGroup'
            => '\\testS\\models\\blocks\\image\\ImageGroupModel',
        'record'
            => '\\testS\\models\\blocks\\record\\RecordModel',
        'recordClone'
            => '\\testS\\models\\blocks\\record\\RecordCloneModel',
        'block'
            => '\\testS\\models\\blocks\\block\\BlockModel',
        'section'
            => '\\testS\\models\\sections\\SectionModel',
        'gridLine'
            => '\\testS\\models\\sections\\GridLineModel',
        'grid'
            => '\\testS\\models\\sections\\GridModel',
        'userSettingsOperation'
            => '\\testS\\models\\user\\UserSettingsOperationModel',
        'userBlockGroupOperation'
            => '\\testS\\models\\user\\UserBlockGroupOperationModel',
        'tab'
            => '\\testS\\models\\blocks\\helpers\\tab\\TabModel',
        'tabGroup'
            => '\\testS\\models\\blocks\\helpers\\tab\\TabGroupModel',
        'tabTemplate'
            => '\\testS\\models\\blocks\\helpers\\tab\\TabTemplateModel',
        'field'
            => '\\testS\\models\\blocks\\helpers\\field\\FieldModel',
        'fieldTemplate'
            => '\\testS\\models\\blocks\\helpers\\field\\FieldTemplateModel',
        'fieldGroup'
            => '\\testS\\models\\blocks\\helpers\\field\\FieldGroupModel',
        'catalog'
            => '\\testS\\models\\blocks\\catalog\\CatalogModel',
        'catalogMenu'
            => '\\testS\\models\\blocks\\catalog\\CatalogMenuModel',
        'search'
            => '\\testS\\models\\blocks\\search\\SearchModel',
        'menu'
            => '\\testS\\models\\blocks\\menu\\MenuModel',
        'menuInstance'
            => '\\testS\\models\\blocks\\menu\\MenuInstanceModel',
        'catalogInstance'
            => '\\testS\\models\\blocks\\catalog\\CatalogInstanceModel',
        'catalogBin'
            => '\\testS\\models\\blocks\\catalog\\CatalogBinModel',
    ];

    /**
     * Runs the command
     *
     * @return void
     */
    public function run()
    {
        $dir = 'dev';
        if (array_key_exists(0, $this->args) === true) {
            $dir = $this->args[0];
        }

        $this->load($dir);
    }

    /**
     * Clear DB script
     *
     * @param string $dir Dir name
     *
     * @return void
     */
    public function load($dir)
    {
        App::getInstance()->getDb()->setLocalhostPdo();

        foreach ($this->_fixtureOrder as $fixture => $modelName) {
            $filePath
                = __DIR__ . '/../fixtures/' . $dir . '/' . $fixture . '.php';

            if (file_exists($filePath) === false) {
                continue;
            }

            $records = include $filePath;
            foreach ($records as $record) {
                $this
                    ->_getModelByName($modelName)
                    ->set($record)
                    ->save();
            }
        }

//        $map = include __DIR__ . '/../fixtures/' . $dir . '/_fileMap.php';
//        foreach ($map as $data) {
//            $mimeType = 'application/octet-stream';
//            if (array_key_exists('mimeType', $data) === true) {
//                $mimeType = $data['mimeType'];
//            }
//
//            $language = Language::LANGUAGE_EN_ID;
//            if (array_key_exists('language', $data) === true) {
//                $language = $data['language'];
//            }
//
//            $this->_sendFile(
//                $data['group'],
//                $data['controller'],
//                $data['file'],
//                $data['data'],
//                $mimeType,
//                $language
//            );
//        }
    }

    /**
     * Gets model by name
     *
     * @param string $modelName Model name
     *
     * @return AbstractModel
     */
    private function _getModelByName($modelName)
    {
        return new $modelName;
    }

    /**
     * Sends a file
     *
     * @param string $group      Group
     * @param string $controller Controller
     * @param string $fileName   File name
     * @param array  $data       Data
     * @param string $mimeType   Mime type
     * @param int    $language   Language
     *
     * @return void
     */
    private function _sendFile(
        $group,
        $controller,
        $fileName,
        array $data = [],
        $mimeType = 'application/octet-stream',
        $language = Language::LANGUAGE_EN_ID
    ) {
        $host = trim(shell_exec("/sbin/ip route|awk '/default/ { print $3 }'"));

        $this->_fileData = [];
        $this->_setFileData($data);
        $postData = [
            'token'      => 'c4ca4238a0b923820dcc509a6f75849b',
            'group'      => $group,
            'controller' => $controller,
            'language'   => $language,
            'file'       => curl_file_create(
                __DIR__ .
                '/../fixtures/files/' .
                $fileName,
                $mimeType
            )
        ];
        $postData = array_merge($postData, $this->_fileData);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, $host . '/api/');
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
        curl_setopt(
            $curl,
            CURLOPT_HTTPHEADER,
            [
                'Content-type: multipart/form-data'
            ]
        );

        curl_exec($curl);
    }

    /**
     * Sets file data
     *
     * @param array  $data   Data
     * @param string $prefix Prefix
     *
     * @return void
     */
    private function _setFileData(array $data, $prefix = 'data')
    {
        foreach ($data as $key => $value) {
            if (is_array($value) === true) {
                $this->_setFileData($value, sprintf('%s[%s]', $prefix, $key));
                continue;
            }

            $this->_fileData[sprintf('%s[%s]', $prefix, $key)] = $value;
        }
    }
}
