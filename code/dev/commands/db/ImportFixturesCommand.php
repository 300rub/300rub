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
     * Token for fixtures
     */
    const FIXTURES_TOKEN = 'c4ca4238a0b923820dcc509a6f75849b';

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
        'helpCategory'
            => '\\ss\\models\\help\\CategoryModel',
        'helpLanguageCategory'
            => '\\ss\\models\\help\\LanguageCategoryModel',
        'helpPage'
            => '\\ss\\models\\help\\PageModel',
        'helpLanguagePage'
            => '\\ss\\models\\help\\LanguagePageModel',
        'systemSite'
            => '\\ss\\models\\system\\SiteModel',
        'systemDomain'
            => '\\ss\\models\\system\\DomainModel',
    ];

    /**
     * Type
     *
     * @var string
     */
    private $_type = '';

    /**
     * Sets type
     *
     * @param string $type Type
     *
     * @return ImportFixturesCommand
     */
    public function setType($type)
    {
        $this->_type = $type;

        return $this;
    }

    /**
     * Runs the command
     *
     * @return void
     */
    public function run()
    {
        if ($this->_type === '') {
            $this->_type = 'dev';
            if (array_key_exists(0, $this->args) === true) {
                $this->_type = $this->args[0];
            }
        }

        $this->load();
    }

    /**
     * Clear DB script
     *
     * @return void
     */
    public function load()
    {
        $config = App::getInstance()->getConfig();
        $dbObject = App::getInstance()->getDb();

        $dbObject->setPdo(
            $config->getValue(['db', $this->_type, 'host']),
            $config->getValue(['db', $this->_type, 'user']),
            $config->getValue(['db', $this->_type, 'password']),
            $config->getValue(['db', $this->_type, 'name'])
        );

        foreach ($this->_fixtureOrder as $fixture => $modelName) {
            $filePath = __DIR__ .
                '/../../fixtures/' .
                $this->_type .
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

        $this
            ->_uploadImages()
            ->_saveRecordInstances();
    }

    /**
     * Saves record instance
     *
     * @return bool
     */
    private function _saveRecordInstances()
    {
        $filePath = __DIR__ .
            '/../../fixtures/' .
            $this->_type .
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
     * @return ImportFixturesCommand
     */
    private function _uploadImages()
    {
        $file = sprintf(
            '%s/fixtures/%s/imageInstances.php',
            CODE_ROOT,
            $this->_type
        );

        if (file_exists($file) === false) {
            return $this;
        }

        $map = include $file;

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
                $language
            );

            $imageInstanceModel = ImageInstanceModel::model()
                ->byId($imageInstanceId)
                ->find();
            $imageInstanceModel->set($data)->save();
        }

        return $this;
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
        array $data,
        $mimeType,
        $language
    ) {
        $host = $this->_type . '.ss.local';

        $this->_fileData = [];
        $this->_setFileData($data);
        $postData = [
            'token'      => self::FIXTURES_TOKEN,
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
