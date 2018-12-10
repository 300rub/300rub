<?php

namespace ss\models\blocks\image\_abstract;

use ss\models\blocks\helpers\file\FileModel;
use ss\application\exceptions\FileException;
use Gregwar\Image\Image;
use ss\models\blocks\image\_base\AbstractImageInstanceModel;

/**
 * Abstract model for working with table "imageInstances"
 */
abstract class AbstractUploadModel extends AbstractImageInstanceModel
{

    /**
     * Extensions
     */
    const EXT_JPG = 'jpg';
    const EXT_PNG = 'png';

    /**
     * Original file model
     *
     * @var FileModel
     */
    private $_originalFileModel = null;

    /**
     * View file model
     *
     * @var FileModel
     */
    private $_viewFileModel = null;

    /**
     * Thumb file model
     *
     * @var FileModel
     */
    private $_thumbFileModel = null;

    /**
     * Extension
     *
     * @var string
     */
    private $_extension = '';

    /**
     * Width
     *
     * @var integer
     */
    private $_width = 0;

    /**
     * Height
     *
     * @var integer
     */
    private $_height = 0;

    /**
     * View width
     *
     * @var integer
     */
    private $_viewWidth = 0;

    /**
     * View height
     *
     * @var integer
     */
    private $_viewHeight = 0;

    /**
     * Thumb width
     *
     * @var integer
     */
    private $_thumbWidth = 0;

    /**
     * Thumb height
     *
     * @var integer
     */
    private $_thumbHeight = 0;

    /**
     * Sets width
     *
     * @param integer $width Width
     *
     * @return AbstractUploadModel
     */
    protected function setWidth($width)
    {
        $this->_width = $width;
        return $this;
    }

    /**
     * Sets height
     *
     * @param integer $height Height
     *
     * @return AbstractUploadModel
     */
    protected function setHeight($height)
    {
        $this->_height = $height;
        return $this;
    }

    /**
     * Gets view width
     *
     * @return int
     */
    protected function getViewWidth()
    {
        return $this->_viewWidth;
    }

    /**
     * Gets view height
     *
     * @return int
     */
    protected function getViewHeight()
    {
        return $this->_viewHeight;
    }


    /**
     * Gets thumb width
     *
     * @return int
     */
    protected function getThumbWidth()
    {
        return $this->_thumbWidth;
    }

    /**
     * Gets thumb height
     *
     * @return int
     */
    protected function getThumbHeight()
    {
        return $this->_thumbHeight;
    }

    /**
     * Uploads a file
     *
     * @return array
     */
    public function upload()
    {
        $this
            ->_checkBeforeUpload()
            ->_setOriginalFileModelFromUploadedFile()
            ->_setParametersForUploadedFile()
            ->_setNewFileModels()
            ->_uploadOriginalFile()
            ->_createTmpViewImageToUpload()
            ->_createTmpThumbImageToUpload()
            ->_uploadViewFile()
            ->_uploadThumbFile()
            ->_save();

        return [
            'originalUrl' => $this->get('originalFileModel')->getUrl(),
            'viewUrl'     => $this->get('viewFileModel')->getUrl(),
            'thumbUrl'    => $this->get('thumbFileModel')->getUrl(),
            'name'        => str_replace(
                sprintf('.%s', $this->_extension),
                '',
                $this->get('originalFileModel')->get('originalName')
            ),
            'id'          => $this->getId()
        ];
    }

    /**
     * Checks before upload
     *
     * @return AbstractUploadModel
     *
     * @throws FileException
     */
    private function _checkBeforeUpload()
    {
        if ($this->get('imageGroupId') === 0) {
            throw new FileException(
                'Unable to upload image because imageGroupId is 0'
            );
        }

        return $this;
    }

    /**
     * Sets original file model from uploaded file
     *
     * @return AbstractUploadModel
     */
    private function _setOriginalFileModelFromUploadedFile()
    {
        $this->_originalFileModel = new FileModel();
        $this->_originalFileModel->parsePostRequest();
        $this->_originalFileModel->set(['isUsed' => true]);

        return $this;
    }

    /**
     * Sets parameters for uploaded file
     *
     * @return AbstractUploadModel
     *
     * @throws FileException
     */
    private function _setParametersForUploadedFile()
    {
        try {
            $info = getimagesize($this->_originalFileModel->getTmpName());

            if (is_array($info) === false) {
                throw new FileException('Uploaded file is not an image');
            }
        } catch (\Exception $e) {
            throw new FileException(
                'Uploaded file: {file} is not an image',
                [
                    'file' => $this->_originalFileModel->get('originalName')
                ]
            );
        }

        if (array_key_exists('mime', $info) === false) {
            throw new FileException(
                'Unable to get image mime. Info: {info}',
                [
                    'info' => json_encode($info)
                ]
            );
        }

        $this->set(
            [
                'width'  => $info[0],
                'height' => $info[1],
                'mime'   => $info['mime']
            ]
        );

        $this
            ->_setExtension($info['mime'])
            ->setWidth($info[0])
            ->setHeight($info[1])
            ->setViewSizes()
            ->setThumbSizes()
            ->set(
                [
                    'width'  => $info[0],
                    'height' => $info[1],
                ]
            );

        return $this;
    }

    /**
     * Sets extension
     *
     * @param string $mime MIME of the file
     *
     * @return AbstractUploadModel
     *
     * @throws FileException
     */
    private function _setExtension($mime)
    {
        if (stripos($mime, 'image') === false) {
            throw new FileException(
                'File with mime: {mime} is not an image',
                [
                    'mime' => $mime
                ]
            );
        }

        if (stripos($mime, 'jpg') !== false
            || stripos($mime, 'jpeg') !== false
        ) {
            $this->_extension = self::EXT_JPG;
            return $this;
        }

        if (stripos($mime, 'png') !== false) {
            $this->_extension = self::EXT_PNG;
            return $this;
        }

        throw new FileException(
            'Unable to upload image with mime: {mime}',
            [
                'mime' => $mime
            ]
        );
    }

    /**
     * Sets view sizes
     *
     * @return AbstractUploadModel
     */
    protected function setViewSizes()
    {
        $this->_viewWidth = $this->_width;
        $this->_viewHeight = $this->_height;

        if ($this->_viewWidth > $this->_viewHeight
            && $this->_viewWidth > self::VIEW_MAX_SIZE
        ) {
            $coefficient = ($this->_viewWidth / self::VIEW_MAX_SIZE);
            $this->_viewWidth = self::VIEW_MAX_SIZE;
            $this->_viewHeight = ($this->_viewHeight / $coefficient);
            return $this;
        }

        if ($this->_viewHeight > self::VIEW_MAX_SIZE) {
            $coefficient = ($this->_viewHeight / self::VIEW_MAX_SIZE);
            $this->_viewHeight = self::VIEW_MAX_SIZE;
            $this->_viewWidth = ($this->_viewWidth / $coefficient);
        }

        return $this;
    }

    /**
     * Sets thumb sizes
     *
     * @return AbstractUploadModel
     */
    protected function setThumbSizes()
    {
        $this->_thumbWidth = $this->_width;
        $this->_thumbHeight = $this->_height;

        if ($this->_thumbWidth > $this->_thumbHeight
            && $this->_thumbWidth > self::THUMB_MAX_SIZE
        ) {
            $coefficient = ($this->_thumbWidth / self::THUMB_MAX_SIZE);
            $this->_thumbWidth = self::THUMB_MAX_SIZE;
            $this->_thumbHeight = ($this->_thumbHeight / $coefficient);
            return $this;
        }

        if ($this->_thumbHeight > self::THUMB_MAX_SIZE) {
            $coefficient = ($this->_thumbHeight / self::THUMB_MAX_SIZE);
            $this->_thumbHeight = self::THUMB_MAX_SIZE;
            $this->_thumbWidth = ($this->_thumbWidth / $coefficient);
        }

        return $this;
    }

    /**
     * Sets new file models
     *
     * @return AbstractUploadModel
     */
    private function _setNewFileModels()
    {
        $this->_originalFileModel->setUniqueName($this->_extension);

        $this->_viewFileModel = new FileModel();
        $this->_viewFileModel
            ->generateTmpName()
            ->setUniqueName($this->_extension)
            ->set(
                [
                    'type'   => $this->_originalFileModel->get('type'),
                    'isUsed' => true
                ]
            );

        $this->_thumbFileModel = new FileModel();
        $this->_thumbFileModel
            ->generateTmpName()
            ->setUniqueName($this->_extension)
            ->set(
                [
                    'type'   => $this->_originalFileModel->get('type'),
                    'isUsed' => true
                ]
            );

        return $this;
    }

    /**
     * Uploads original file
     *
     * @return AbstractUploadModel
     */
    private function _uploadOriginalFile()
    {
        $this->_originalFileModel->upload();
        return $this;
    }

    /**
     * Uploads view file
     *
     * @return AbstractUploadModel
     */
    private function _uploadViewFile()
    {
        $this->_viewFileModel->upload();
        return $this;
    }

    /**
     * Uploads thumb file
     *
     * @return AbstractUploadModel
     */
    private function _uploadThumbFile()
    {
        $this->_thumbFileModel->upload();
        return $this;
    }

    /**
     * Creates view tmp image to upload
     *
     * @return AbstractUploadModel
     */
    private function _createTmpViewImageToUpload()
    {
        Image::open($this->_originalFileModel->getUrl())
            ->resize($this->_viewWidth, $this->_viewHeight)
            ->save($this->_viewFileModel->getTmpName());

        return $this;
    }

    /**
     * Creates thumb tmp image to upload
     *
     * @return AbstractUploadModel
     */
    private function _createTmpThumbImageToUpload()
    {
        Image::open($this->_originalFileModel->getUrl())
            ->resize($this->_thumbWidth, $this->_thumbHeight)
            ->save($this->_thumbFileModel->getTmpName());

        return $this;
    }

    /**
     * Saves the model
     *
     * @return AbstractUploadModel
     */
    private function _save()
    {
        $this->set(
            [
                'originalFileModel' => $this->_originalFileModel,
                'viewFileModel'     => $this->_viewFileModel,
                'thumbFileModel'    => $this->_thumbFileModel,
            ]
        );

        $this->save();

        return $this;
    }
}
