<?php

namespace testS\models\blocks\image;

use testS\application\components\Db;
use testS\application\exceptions\FileException;
use Gregwar\Image\Image;
use testS\models\blocks\helpers\file\FileModel;
use testS\models\blocks\image\_abstract\AbstractImageInstanceModel;

/**
 * Model for working with table "imageInstances"
 */
class ImageInstanceModel extends AbstractImageInstanceModel
{

    /**
     * Max size in px
     */
    const VIEW_MAX_SIZE = 2000;

    /**
     * Max thumb size in px
     */
    const THUMB_MAX_SIZE = 300;

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
     * Is view changed
     *
     * @var boolean
     */
    private $_isViewChanged = false;

    /**
     * Is thumb changed
     *
     * @var boolean
     */
    private $_isThumbChanged = false;

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
     * @return ImageInstanceModel
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
     * @return ImageInstanceModel
     */
    private function _setOriginalFileModelFromUploadedFile()
    {
        $this->_originalFileModel = new FileModel();
        $this->_originalFileModel->parsePostRequest();

        return $this;
    }

    /**
     * Sets parameters for uploaded file
     *
     * @return ImageInstanceModel
     *
     * @throws FileException
     */
    private function _setParametersForUploadedFile()
    {
        $info = getimagesize($this->_originalFileModel->getTmpName());
        if (is_array($info) === false) {
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
            ->_setSizes($info[0], $info[1]);

        return $this;
    }

    /**
     * Sets extension
     *
     * @param string $mime MIME of the file
     *
     * @return ImageInstanceModel
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
     * Sets sizes
     *
     * @param int $originalWidth  Original width
     * @param int $originalHeight Original height
     *
     * @return ImageInstanceModel
     */
    private function _setSizes($originalWidth, $originalHeight)
    {
        $viewWidth = $originalWidth;
        $viewHeight = $originalHeight;
        $thumbWidth = $originalWidth;
        $thumbHeight = $originalHeight;

        if ($originalWidth > $originalHeight) {
            if ($viewWidth > self::VIEW_MAX_SIZE) {
                $coefficient = ($viewWidth / self::VIEW_MAX_SIZE);
                $viewWidth = self::VIEW_MAX_SIZE;
                $viewHeight = ($viewHeight / $coefficient);
            }

            if ($thumbWidth > self::THUMB_MAX_SIZE) {
                $coefficient = ($thumbWidth / self::THUMB_MAX_SIZE);
                $thumbWidth = self::THUMB_MAX_SIZE;
                $thumbHeight = ($thumbHeight / $coefficient);
            }
        } else {
            if ($viewHeight > self::VIEW_MAX_SIZE) {
                $coefficient = ($viewHeight / self::VIEW_MAX_SIZE);
                $viewHeight = self::VIEW_MAX_SIZE;
                $viewWidth = ($viewWidth / $coefficient);
            }

            if ($thumbHeight > self::THUMB_MAX_SIZE) {
                $coefficient = ($thumbHeight / self::THUMB_MAX_SIZE);
                $thumbHeight = self::THUMB_MAX_SIZE;
                $thumbWidth = ($thumbWidth / $coefficient);
            }
        }

        $this->set(
            [
                'width'  => $originalWidth,
                'height' => $originalHeight,
            ]
        );

        $this->_viewWidth = $viewWidth;
        $this->_viewHeight = $viewHeight;
        $this->_thumbWidth = $thumbWidth;
        $this->_thumbHeight = $thumbHeight;

        return $this;
    }

    /**
     * Sets new file models
     *
     * @return ImageInstanceModel
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
                    'type' => $this->_originalFileModel->get('type')
                ]
            );

        $this->_thumbFileModel = new FileModel();
        $this->_thumbFileModel
            ->generateTmpName()
            ->setUniqueName($this->_extension)
            ->set(
                [
                    'type' => $this->_originalFileModel->get('type')
                ]
            );

        return $this;
    }

    /**
     * Uploads original file
     *
     * @return ImageInstanceModel
     */
    private function _uploadOriginalFile()
    {
        $this->_originalFileModel->upload();
        return $this;
    }

    /**
     * Uploads view file
     *
     * @return ImageInstanceModel
     */
    private function _uploadViewFile()
    {
        $this->_viewFileModel->upload();
        return $this;
    }

    /**
     * Uploads thumb file
     *
     * @return ImageInstanceModel
     */
    private function _uploadThumbFile()
    {
        $this->_thumbFileModel->upload();
        return $this;
    }

    /**
     * Creates view tmp image to upload
     *
     * @return ImageInstanceModel
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
     * @return ImageInstanceModel
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
     * @return ImageInstanceModel
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

    /**
     * Updates the image
     *
     * @param array $data Request data
     *
     * @return array
     */
    public function update(array $data)
    {
        $viewName = $this->get('viewFileModel')->get('uniqueName');
        $thumbName = $this->get('thumbFileModel')->get('uniqueName');

        $this
            ->_updateView($data)
            ->_updateThumb($data)
            ->_updateImage($data);

        $file = new FileModel();

        if ($this->_isViewChanged === true) {
            $file->deleteByUniqueName($viewName);
        }

        if ($this->_isThumbChanged === true) {
            $file->deleteByUniqueName($thumbName);
        }

        return [
            'originalUrl' => $this->get('originalFileModel')->getUrl(),
            'viewUrl'     => $this->get('viewFileModel')->getUrl(),
            'thumbUrl'    => $this->get('thumbFileModel')->getUrl(),
        ];
    }

    /**
     * Updates the view file
     *
     * @param array $data Request data
     *
     * @return ImageInstanceModel
     *
     * @SuppressWarnings(PMD.StaticAccess)
     */
    private function _updateView(array $data)
    {
        if ($data['x1'] === $this->get('x1')
            && $data['x2'] === $this->get('x2')
            && $data['y1'] === $this->get('y1')
            && $data['y2'] === $this->get('y2')
            && $data['angle'] === $this->get('angle')
            && $data['flip'] === $this->get('flip')
        ) {
            return $this;
        }

        $viewFileModel = $this->get('viewFileModel');

        $viewFileModel->generateTmpName();
        $viewFileModel->setUniqueName(
            trim(
                strtolower(
                    pathinfo(
                        $viewFileModel->get('uniqueName'),
                        PATHINFO_EXTENSION
                    )
                )
            )
        );

        $image = Image::open(
            $this->get('originalFileModel')->getUrl()
        );

        switch ($data['flip']) {
            case self::FLIP_BOTH:
                $image->flip(true, true);
                break;
            case self::FLIP_HORIZONTAL:
                $image->flip(false, true);
                break;
            case self::FLIP_VERTICAL:
                $image->flip(true, false);
                break;
        }

        if ($data['angle'] !== 0) {
            $image->rotate($data['angle']);
        }

        $viewWidth = ($data['x2'] - $data['x1']);
        $viewHeight = ($data['y2'] - $data['y1']);

        $image->crop($data['x1'], $data['y1'], $viewWidth, $viewHeight);

        if ($viewWidth > $viewHeight) {
            if ($viewWidth > self::VIEW_MAX_SIZE) {
                $coefficient = ($viewWidth / self::VIEW_MAX_SIZE);
                $viewWidth = self::VIEW_MAX_SIZE;
                $viewHeight = ($viewHeight / $coefficient);
            }
        } else {
            if ($viewHeight > self::VIEW_MAX_SIZE) {
                $coefficient = ($viewHeight / self::VIEW_MAX_SIZE);
                $viewHeight = self::VIEW_MAX_SIZE;
                $viewWidth = ($viewWidth / $coefficient);
            }
        }

        $image->resize($viewWidth, $viewHeight);
        $image->save($viewFileModel->getTmpName());
        $viewFileModel->upload();

        $viewFileModel->save();

        $this->_isViewChanged = true;

        return $this;
    }

    /**
     * Updates the thumb file
     *
     * @param array $data Request data
     *
     * @return ImageInstanceModel
     *
     * @SuppressWarnings(PMD.StaticAccess)
     */
    private function _updateThumb(array $data)
    {
        if ($data['thumbX1'] === $this->get('thumbX1')
            && $data['thumbX2'] === $this->get('thumbX2')
            && $data['thumbY1'] === $this->get('thumbY1')
            && $data['thumbY2'] === $this->get('thumbY2')
            && $data['angle'] === $this->get('angle')
            && $data['flip'] === $this->get('flip')
        ) {
            return $this;
        }

        $thumbFileModel = $this->get('thumbFileModel');

        $thumbFileModel->generateTmpName();
        $thumbFileModel->setUniqueName(
            trim(
                strtolower(
                    pathinfo(
                        $thumbFileModel->get('uniqueName'),
                        PATHINFO_EXTENSION
                    )
                )
            )
        );

        $image = Image::open(
            $this->get('originalFileModel')->getUrl()
        );

        switch ($data['flip']) {
            case self::FLIP_BOTH:
                $image->flip(true, true);
                break;
            case self::FLIP_HORIZONTAL:
                $image->flip(false, true);
                break;
            case self::FLIP_VERTICAL:
                $image->flip(true, false);
                break;
        }

        if ($data['angle'] !== 0) {
            $image->rotate($data['angle']);
        }

        $thumbWidth = ($data['thumbX2'] - $data['thumbX1']);
        $thumbHeight = ($data['thumbY2'] - $data['thumbY1']);

        $image->crop(
            $data['thumbX1'],
            $data['thumbY1'],
            $thumbWidth,
            $thumbHeight
        );

        if ($thumbWidth > $thumbHeight) {
            if ($thumbWidth > self::THUMB_MAX_SIZE) {
                $coefficient = ($thumbWidth / self::THUMB_MAX_SIZE);
                $thumbWidth = self::THUMB_MAX_SIZE;
                $thumbHeight = ($thumbHeight / $coefficient);
            }
        } else {
            if ($thumbHeight > self::THUMB_MAX_SIZE) {
                $coefficient = ($thumbHeight / self::THUMB_MAX_SIZE);
                $thumbHeight = self::THUMB_MAX_SIZE;
                $thumbWidth = ($thumbWidth / $coefficient);
            }
        }

        $this->_setSizes($thumbWidth, $thumbHeight);

        $image->resize($this->_thumbWidth, $this->_thumbHeight);
        $image->save($thumbFileModel->getTmpName());
        $thumbFileModel->upload();

        $thumbFileModel->save();

        $this->_isThumbChanged = true;

        return $this;
    }

    /**
     * Updates the image
     *
     * @param array $data Request data
     *
     * @return ImageInstanceModel
     */
    private function _updateImage(array $data)
    {
        if ($data['isCover'] !== $this->get('isCover')
            && $data['isCover'] === true
        ) {
            $this->updateMany(
                ['isCover' => 0],
                'imageGroupId = :imageGroupId',
                ['imageGroupId' => $this->get('imageGroupId')]
            );
        }

        $this->set($data);
        $this->save();

        return $this;
    }

    /**
     * Adds SQL condition to select cover
     *
     * @param int $groupId Group ID
     *
     * @return ImageInstanceModel
     */
    public function coverByGroupId($groupId)
    {
        $this->getDb()->addWhere('t.imageGroupId = :imageGroupId');
        $this->getDb()->addParameter('imageGroupId', $groupId);
        $this->getDb()->setOrder('t.isCover DESC, t.sort');
        $this->getDb()->setLimit(1);

        return $this;
    }

    /**
     * Adds SQL condition by group ID
     *
     * @param int $groupId Group ID
     *
     * @return ImageInstanceModel
     */
    public function byGroupId($groupId)
    {
        $this->getDb()->addWhere('t.imageGroupId = :imageGroupId');
        $this->getDb()->addParameter('imageGroupId', $groupId);

        return $this;
    }

    /**
     * Adds SQL condition by image ID
     *
     * @param int $imageId Image ID
     *
     * @return ImageInstanceModel
     */
    public function byImageId($imageId)
    {
        $this->getDb()->addJoin(
            'imageGroups',
            'imageGroups',
            Db::DEFAULT_ALIAS,
            'imageGroupId'
        );

        $this->getDb()->addWhere(
            'imageGroups.imageId = :imageId'
        );
        $this->getDb()->addParameter('imageId', $imageId);

        return $this;
    }
}
