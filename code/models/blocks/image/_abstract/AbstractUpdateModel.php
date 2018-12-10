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
     * Updates the image
     *
     * @param array $data Request data
     *
     * @return array
     */
    public function crop(array $data)
    {
        $this
            ->_updateView($data)
            ->_updateThumb($data);

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
        if ($data['viewX'] === $this->get('viewX')
            && $data['viewY'] === $this->get('viewY')
            && $data['viewWidth'] === $this->get('viewWidth')
            && $data['viewHeight'] === $this->get('viewHeight')
            && $data['viewAngle'] === $this->get('viewAngle')
            && $data['viewFlip'] === $this->get('viewFlip')
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

        $oldViewFileModel = $this->get('viewFileModel');
        $newViewFileModel = $this->_getNewFileModel($oldViewFileModel);

        $newViewFileModel->generateTmpName();
        $newViewFileModel->setUniqueName(
            trim(
                strtolower(
                    pathinfo(
                        $newViewFileModel->get('uniqueName'),
                        PATHINFO_EXTENSION
                    )
                )
            )
        );

        $image = Image::open(
            $this->get('originalFileModel')->getUrl()
        );

        $image->setForceCache(false);

        switch ($data['viewFlip']) {
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

        if ($data['viewAngle'] !== 0) {
            $image->rotate($data['viewAngle'] * -1);
        }

        $image->crop(
            $data['viewX'],
            $data['viewY'],
            $data['viewWidth'],
            $data['viewHeight']
        );

        $this
            ->setWidth($data['viewWidth'])
            ->setHeight($data['viewHeight'])
            ->setViewSizes();

        $image->resize($this->getViewWidth(), $this->getViewHeight());
        $image->save($newViewFileModel->getTmpName());
        $newViewFileModel->upload();

        $newViewFileModel->save();

        $oldViewFileModel->markAsUnused();

        $this->set(
            [
                'viewFileId'    => $newViewFileModel->getId(),
                'viewFileModel' => $newViewFileModel,
            ]
        );

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

        $oldThumbFileModel = $this->get('thumbFileModel');
        $newThumbFileModel = $this->_getNewFileModel($oldThumbFileModel);

        $newThumbFileModel->generateTmpName();
        $newThumbFileModel->setUniqueName(
            trim(
                strtolower(
                    pathinfo(
                        $newThumbFileModel->get('uniqueName'),
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
        $image->save($newThumbFileModel->getTmpName());
        $newThumbFileModel->upload();

        $newThumbFileModel->save();

        $oldThumbFileModel->markAsUnused();

        $this->set(
            [
                'thumbFileId'    => $newThumbFileModel->getId(),
                'thumbFileModel' => $newThumbFileModel,
            ]
        );

        return $this;
    }

    /**
     * Gets new File Model
     *
     * @param FileModel $oldFileModel File Model
     *
     * @return FileModel
     */
    private function _getNewFileModel($oldFileModel)
    {
        $newFileModel = clone $oldFileModel;
        $newFileModel->clearId();
        $newFileModel->set(['isUsed' => true]);
        return $newFileModel;
    }
}
