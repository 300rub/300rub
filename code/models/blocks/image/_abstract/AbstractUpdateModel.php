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
            && $data['x2'] === $this->get('x2')
            && $data['y1'] === $this->get('y1')
            && $data['y2'] === $this->get('y2')
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

        $this
            ->setWidth($viewWidth)
            ->setHeight($viewHeight)
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
        if ($data['thumbX1'] === $this->get('thumbX1')
            && $data['thumbX2'] === $this->get('thumbX2')
            && $data['thumbY1'] === $this->get('thumbY1')
            && $data['thumbY2'] === $this->get('thumbY2')
            && $data['angle'] === $this->get('angle')
            && $data['flip'] === $this->get('flip')
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
            $image->rotate($data['thumbAngle']);
        }

        $thumbWidth = ($data['thumbX2'] - $data['thumbX1']);
        $thumbHeight = ($data['thumbY2'] - $data['thumbY1']);

        $image->crop(
            $data['thumbX1'],
            $data['thumbY1'],
            $thumbWidth,
            $thumbHeight
        );

        $this
            ->setWidth($thumbWidth)
            ->setHeight($thumbHeight)
            ->setThumbSizes();

        $image->resize($this->getThumbWidth(), $this->getThumbHeight());
        $image->save($thumbFileModel->getTmpName());
        $thumbFileModel->upload();

        $thumbFileModel->save();

        $this->_isThumbChanged = true;

        return $this;
    }
}
