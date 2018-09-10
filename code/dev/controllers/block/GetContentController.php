<?php

namespace ss\controllers\block;

use ss\application\App;
use ss\controllers\_abstract\AbstractController;
use ss\models\blocks\block\BlockModel;

/**
 * Gets blocks content
 */
class GetContentController extends AbstractController
{

    /**
     * Content
     *
     * @var array
     */
    private $_content = [];

    /**
     * Runs controller
     *
     * @return array
     */
    public function run()
    {
        $this->checkData(
            [
                'uri' => [self::TYPE_STRING, self::NOT_EMPTY],
            ]
        );

        $idList = $this->get('idList');
        if (is_array($idList) === false) {
            $idList = [];
        }

        App::getInstance()->getSite()->setUri($this->get('uri'));

        foreach ($idList as $blockId) {
            if (array_key_exists($blockId, $this->_content) === true) {
                continue;
            }

            $blockModel = BlockModel::model()
                ->getById($blockId)
                ->setContent();

            $this->_content[$blockId] = [
                'html' => $blockModel->getHtml(),
                'css'  => $blockModel->getCss(),
                'js'   => $blockModel->getJs(),
            ];
        }

        return [
            'content' => $this->_content
        ];
    }
}
