<?php

namespace ss\models\blocks\image\_abstract;

use Gregwar\Image\Image;
use ss\models\blocks\helpers\file\FileModel;

/**
 * Abstract model for working with table "imageInstances"
 */
abstract class AbstractUpdateModel extends AbstractUploadModel
{

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
     * Updates the image
     *
     * @param array $data Request data
     *
     * @return array
     */
    public function crop(array $data)
    {
        $viewName = $this->get('viewFileModel')->get('uniqueName');
        $thumbName = $this->get('thumbFileModel')->get('uniqueName');

        $this
            ->_updateView($data)
            ->_updateThumb($data);

        $file = new FileModel();

        if ($this->_isViewChanged === true) {
            $file->deleteByUniqueName($viewName);
        }

        if ($this->_isThumbChanged === true) {
            $file->deleteByUniqueName($thumbName);
        }

        $this->set($data)->save();

        return [
            'originalUrl' => $this->get('originalFileModel')->getUrl(),
            'viewUrl'     => $this->get('viewFileModel')->getUrl(),
            'thumbUrl'    => $this->get('thumbFileModel')->getUrl(),
        ];
    }

    /**
     * Updates the image
     *
     * @param array $data Request data
     *
     * @return AbstractUpdateModel
     */
    public function update(array $data)
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
     * Is changed view data
     *
     * @param array $data Request data
     *
     * @return bool
     */
    private function _isChangedViewData(array $data)
    {
        if ($data['x1'] === $this->get('x1')
            && $data['y1'] === $this->get('y1')
            && $data['viewWidth'] === $this->get('viewWidth')
            && $data['viewHeight'] === $this->get('viewHeight')
            && $data['angle'] === $this->get('angle')
            && $data['flip'] === $this->get('flip')
        ) {
            return false;
        }

        return true;
    }

    /**
     * Updates the view file
     *
     * @param array $data Request data
     *
     * @return AbstractUpdateModel
     *
     * @SuppressWarnings(PMD.StaticAccess)
     */
    private function _updateView(array $data)
    {
        if ($this->_isChangedViewData($data) === false) {
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

        $image->setForceCache(false);

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
            $image->rotate($data['angle'] * -1);
        }

        $image->crop(
            $data['x1'],
            $data['y1'],
            $data['viewWidth'],
            $data['viewHeight']
        );

        $this
            ->setWidth($data['viewWidth'])
            ->setHeight($data['viewHeight'])
            ->setViewSizes();

        $image->resize($this->getViewWidth(), $this->getViewHeight());
        $image->save($viewFileModel->getTmpName());
        $viewFileModel->upload();

        $viewFileModel->save();

        $this->_isViewChanged = true;

        return $this;
    }

    /**
     * Is changed thumb data
     *
     * @param array $data Request data
     *
     * @return bool
     */
    private function _isChangedThumbData(array $data)
    {
        if ($data['thumbX'] === $this->get('thumbX')
            && $data['thumbY'] === $this->get('thumbY')
            && $data['thumbWidth'] === $this->get('thumbWidth')
            && $data['thumbHeight'] === $this->get('thumbHeight')
            && $data['thumbAngle'] === $this->get('thumbAngle')
            && $data['thumbFlip'] === $this->get('thumbFlip')
        ) {
            return false;
        }

        return true;
    }

    /**
     * Updates the thumb file
     *
     * @param array $data Request data
     *
     * @return AbstractUpdateModel
     *
     * @SuppressWarnings(PMD.StaticAccess)
     */
    private function _updateThumb(array $data)
    {
        if ($this->_isChangedThumbData($data) === false) {
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

        $image->setForceCache(false);

        switch ($data['thumbFlip']) {
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

        if ($data['thumbAngle'] !== 0) {
            $image->rotate($data['thumbAngle'] * -1);
        }

        $image->crop(
            $data['thumbX'],
            $data['thumbY'],
            $data['thumbWidth'],
            $data['thumbHeight']
        );

        $this
            ->setWidth($data['thumbWidth'])
            ->setHeight($data['thumbHeight'])
            ->setThumbSizes();

        $image->resize($this->getThumbWidth(), $this->getThumbHeight());
        $image->save($thumbFileModel->getTmpName());
        $thumbFileModel->upload();

        $thumbFileModel->save();

        $this->_isThumbChanged = true;

        return $this;
    }
}
