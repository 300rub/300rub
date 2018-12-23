use ss\models\blocks\image\ImageModel;
abstract class AbstractUploadModel extends AbstractAutoCropModel
    /**
     * Image model
     *
     * @var ImageModel
     */
    private $_imageModel = null;

            ->_createViewImage()
            ->_createThumbImage()
    /**
     * Gets ImageModel
     *
     * @return ImageModel
     */
    private function _getImageModel()
    {
        if ($this->_imageModel === null) {
            $this->_imageModel = ImageModel::model()->findByGroupId(
                $this->get('imageGroupId')
            );
        }

        return $this->_imageModel;
    }

                    'type' => $this->_originalFileModel->get('type')
                    'type' => $this->_originalFileModel->get('type')
    private function _createViewImage()
        $image = Image::open($this->_originalFileModel->getUrl());

        if ($this->_viewWidth !== $this->_width
            || $this->_viewHeight !== $this->_height
        ) {
            $image->resize($this->_viewWidth, $this->_viewHeight);
        }

        if ($this->_getImageModel() !== null) {
            $image = $this->autoCrop(
                $image,
                $this->_getImageModel()->get('viewAutoCropType'),
                $this->_getImageModel()->get('viewCropX'),
                $this->_getImageModel()->get('viewCropY'),
                $this->_viewWidth,
                $this->_viewHeight
            );
        }

        $image->save($this->_viewFileModel->getTmpName());
    private function _createThumbImage()
        $image = Image::open($this->_originalFileModel->getUrl());

        if ($this->_thumbWidth !== $this->_width
            || $this->_thumbHeight !== $this->_height
        ) {
            $image->resize($this->_thumbWidth, $this->_thumbHeight);
        }

        if ($this->_getImageModel() !== null) {
            $image = $this->autoCrop(
                $image,
                $this->_getImageModel()->get('thumbAutoCropType'),
                $this->_getImageModel()->get('thumbCropX'),
                $this->_getImageModel()->get('thumbCropY'),
                $this->_thumbWidth,
                $this->_thumbHeight
            );
        }

        $image->save($this->_thumbFileModel->getTmpName());