<?php

namespace ss\commands\db;

use ss\application\App;
use ss\application\components\Language;
use ss\commands\_abstract\AbstractCommand;
use ss\models\_abstract\AbstractModel;
use ss\models\blocks\image\ImageInstanceModel;
use ss\models\blocks\record\RecordInstanceModel;

/**
 * Load fixtures command
 */
class ImportFixturesCommand extends AbstractCommand
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
            => '\\ss\\models\\user\\UserModel',
        'userSession'
            => '\\ss\\models\\user\\UserSessionModel',
        'text'
            => '\\ss\\models\\blocks\\text\\TextModel',
        'textInstance'
            => '\\ss\\models\\blocks\\text\\TextInstanceModel',
        'image'
            => '\\ss\\models\\blocks\\image\\ImageModel',
        'imageGroup'
            => '\\ss\\models\\blocks\\image\\ImageGroupModel',
        'record'
            => '\\ss\\models\\blocks\\record\\RecordModel',
        'recordClone'
            => '\\ss\\models\\blocks\\record\\RecordCloneModel',
        'menu'
            => '\\ss\\models\\blocks\\menu\\MenuModel',
        'block'
            => '\\ss\\models\\blocks\\block\\BlockModel',
        'section'
            => '\\ss\\models\\sections\\SectionModel',
        'gridLine'
            => '\\ss\\models\\sections\\GridLineModel',
        'grid'
            => '\\ss\\models\\sections\\GridModel',
        'userSettingsOperation'
            => '\\ss\\models\\user\\UserSettingsOperationModel',
        'userBlockGroupOperation'
            => '\\ss\\models\\user\\UserBlockGroupOperationModel',
        'tab'
            => '\\ss\\models\\blocks\\helpers\\tab\\TabModel',
        'tabGroup'
            => '\\ss\\models\\blocks\\helpers\\tab\\TabGroupModel',
        'tabTemplate'
            => '\\ss\\models\\blocks\\helpers\\tab\\TabTemplateModel',
        'field'
            => '\\ss\\models\\blocks\\helpers\\field\\FieldModel',
        'fieldTemplate'
            => '\\ss\\models\\blocks\\helpers\\field\\FieldTemplateModel',
        'fieldGroup'
            => '\\ss\\models\\blocks\\helpers\\field\\FieldGroupModel',
        'catalog'
            => '\\ss\\models\\blocks\\catalog\\CatalogModel',
        'catalogMenu'
            => '\\ss\\models\\blocks\\catalog\\CatalogMenuModel',
        'search'
            => '\\ss\\models\\blocks\\search\\SearchModel',
        'menuInstance'
            => '\\ss\\models\\blocks\\menu\\MenuInstanceModel',
        'catalogInstance'
            => '\\ss\\models\\blocks\\catalog\\CatalogInstanceModel',
        'catalogBin'
            => '\\ss\\models\\blocks\\catalog\\CatalogBinModel',
    ];

    /**
     * Runs the command
     *
     * @return void
     */
    public function run()
    {
        $type = 'dev';
        if (array_key_exists(0, $this->args) === true
            && $this->args[0] === 'phpunit'
        ) {
            $type = $this->args[0];
        }

        $this->load($type);
    }

    /**
     * Clear DB script
     *
     * @param string $type Type
     *
     * @return void
     */
    public function load($type)
    {
        $config = App::getInstance()->getConfig();
        $dbObject = App::getInstance()->getDb();

        $dbObject->setPdo(
            $config->getValue(['db', $type, 'host']),
            $config->getValue(['db', $type, 'user']),
            $config->getValue(['db', $type, 'password']),
            $config->getValue(['db', $type, 'name'])
        );

        $dbObject->execute('SET GLOBAL FOREIGN_KEY_CHECKS=0;');

        foreach ($this->_fixtureOrder as $fixture => $modelName) {
            $filePath = __DIR__ .
                '/../../fixtures/' .
                $type .
                '/' .
                $fixture .
                '.php';

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

        $this->_uploadImages($type);

        $this->_saveRecordInstances($type);

        $dbObject->execute('SET GLOBAL FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Saves record instance
     *
     * @param string $type Type
     *
     * @return bool
     */
    private function _saveRecordInstances($type)
    {
        $filePath = __DIR__ .
            '/../../fixtures/' .
            $type .
            '/recordInstance.php';

        if (file_exists($filePath) === false) {
            return false;
        }

        $records = include $filePath;
        foreach ($records as $data) {
            $model = new RecordInstanceModel();
            $model->set(
                [
                    'recordId' => $data['recordId'],
                    'seoModel' => $data['seoModel']
                ]
            );
            $model->save();

            $model->set($data)->save();

            if (array_key_exists('imageGroupId', $data) === true) {
                $dbObject = App::getInstance()->getDb();
                $dbObject->execute(
                    'UPDATE ' .
                    'recordInstances SET imageGroupId = ? WHERE id = ?',
                    [
                        $data['imageGroupId'],
                        $model->getId()
                    ]
                );
            }
        }

        return true;
    }

    /**
     * Uploads image
     *
     * @param string $type Type
     *
     * @return void
     */
    private function _uploadImages($type)
    {
        $map = include sprintf(
            '%s/fixtures/%s/imageInstances.php',
            CODE_ROOT,
            $type
        );

        foreach ($map as $imageInstanceId => $data) {
            $mimeType = 'application/octet-stream';
            if (array_key_exists('mimeType', $data) === true) {
                $mimeType = $data['mimeType'];
            }

            $language = Language::LANGUAGE_EN_ID;
            if (array_key_exists('language', $data) === true) {
                $language = $data['language'];
            }

            $this->_sendFile(
                $data['group'],
                $data['controller'],
                $data['file'],
                $data['data'],
                $mimeType,
                $language,
                $type
            );

            $imageInstanceModel = ImageInstanceModel::model()
                ->byId($imageInstanceId)
                ->find();
            $imageInstanceModel->set($data)->save();
        }
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
     * @param string $type       Type
     *
     * @return void
     */
    private function _sendFile(
        $group,
        $controller,
        $fileName,
        array $data,
        $mimeType,
        $language,
        $type
    ) {
        $host = $type . '.ss.local';

        $this->_fileData = [];
        $this->_setFileData($data);
        $postData = [
            'token'      => 'c4ca4238a0b923820dcc509a6f75849b',
            'group'      => $group,
            'controller' => $controller,
            'language'   => $language,
            'file'       => curl_file_create(
                __DIR__ .
                '/../../fixtures/files/' .
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
                'Content-type: multipart/form-data',
                'X-Requested-With: XMLHttpRequest'
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
