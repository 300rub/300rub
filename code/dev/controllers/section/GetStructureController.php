<?php

namespace ss\controllers\section;

use ss\application\App;
use ss\application\components\db\Table;
use ss\application\components\user\Operation;
use ss\application\exceptions\NotFoundException;
use ss\controllers\_abstract\AbstractController;
use ss\models\blocks\block\BlockModel;
use ss\models\blocks\record\RecordCloneModel;
use ss\models\sections\GridLineModel;
use ss\models\sections\GridModel;
use ss\models\sections\SectionModel;

/**
 * Gets section structure
 */
class GetStructureController extends AbstractController
{

    /**
     * Block models
     *
     * @var array
     */
    private $_blocks = [];

    /**
     * Section model
     *
     * @var SectionModel
     */
    private $_section = null;

    /**
     * Structure
     *
     * @var array
     */
    private $_structure = [];

    /**
     * Filtered blocks
     *
     * @var array
     */
    private $_filteredBlocks = [];

    /**
     * Runs controller
     *
     * @return array
     */
    public function run()
    {
        $this->checkSectionOperation(
            Operation::SECTION_UPDATE_CONTENT
        );

        $this->checkData(
            [
                'id' => [self::NOT_EMPTY],
            ]
        );

        $this
            ->_setSection()
            ->_setBlocks()
            ->_setStructure()
            ->_setFilteredBlocks();

        return [
            'title'     => $this->_section->get('seoModel')->get('name'),
            'structure' => $this->_structure,
            'blocks'    => $this->_filteredBlocks,
        ];
    }

    /**
     * Sets section model
     *
     * @return GetStructureController
     *
     * @throws NotFoundException
     */
    private function _setSection()
    {
        $this->_section = SectionModel::model()
            ->byId($this->get('id'))
            ->withRelations(['seoModel'])
            ->find();

        if ($this->_section === null) {
            throw new NotFoundException(
                'Unable to find section with ID: {id}',
                [
                    'id' => $this->get('id')
                ]
            );
        }

        return $this;
    }

    /**
     * Sets block models
     *
     * @return GetStructureController
     */
    private function _setBlocks()
    {
        $blocks = BlockModel::model()
            ->byLanguage(App::getInstance()->getLanguage()->getActiveId())
            ->ordered()
            ->findAll(true);

        $this->_blocks = [];
        foreach ($blocks as $block) {
            $idKey = sprintf(
                '%s%s%s',
                Table::DEFAULT_ALIAS,
                Table::SEPARATOR,
                BlockModel::PK_FIELD
            );
            $nameKey = sprintf(
                '%s%sname',
                Table::DEFAULT_ALIAS,
                Table::SEPARATOR
            );
            $typeKey = sprintf(
                '%s%scontentType',
                Table::DEFAULT_ALIAS,
                Table::SEPARATOR
            );
            $contentIdKey = sprintf(
                '%s%scontentId',
                Table::DEFAULT_ALIAS,
                Table::SEPARATOR
            );

            $this->_blocks[(int)$block[$idKey]] = [
                'name'      => $block[$nameKey],
                'type'      => (int)$block[$typeKey],
                'contentId' => (int)$block[$contentIdKey],
            ];
        }

        return $this;
    }

    /**
     * Sets structure
     *
     * @return GetStructureController
     */
    private function _setStructure()
    {
        $this->_structure = [];

        $gridLineModels = GridLineModel::model()
            ->bySectionId()
            ->ordered('sort')
            ->findAll();

        $gridLineIds = [];
        foreach ($gridLineModels as $gridLineModel) {
            $gridLineIds[] = $gridLineModel->getId();
        }

        $gridModels = GridModel::model()
            ->addIn('gridLineId', $gridLineIds)
            ->ordered(['y', 'x']);
        $gridModels = $gridModels->findAll();

        foreach ($gridLineModels as $gridLineModel) {
            $lineGrids = [];

            foreach ($gridModels as $gridModel) {
                if ($gridModel->get('gridLineId') === $gridLineModel->getId()) {
                    $blockId = $gridModel->get('blockId');
                    if (array_key_exists($blockId, $this->_blocks) === false) {
                        continue;
                    }

                    $lineGrids[] = [
                        'block' => $this->_blocks[$blockId],
                        'x'     => $gridModel->get('x'),
                        'y'     => $gridModel->get('y'),
                        'width' => $gridModel->get('width'),
                    ];
                }
            }

            $this->_structure[] = [
                'grids' => $lineGrids
            ];
        }

        return $this;
    }

    /**
     * Sets filtered blocks
     *
     * @return GetStructureController
     */
    private function _setFilteredBlocks()
    {
        $this->_filteredBlocks = [
            $this->_getSimpleBlocks(BlockModel::TYPE_TEXT),
            $this->_getSimpleBlocks(BlockModel::TYPE_IMAGE),
            $this->_getSimpleBlocks(BlockModel::TYPE_MENU),
            $this->_getRecordBlocks()
        ];

        return $this;
    }

    /**
     * Gets simple blocks (Without clones)
     *
     * @param int $type Block type
     *
     * @return array
     */
    private function _getSimpleBlocks($type)
    {
        $filteredBlocks = [];
        foreach ($this->_blocks as $blockId => $data) {
            if ($data['type'] === $type) {
                $filteredBlocks[] = [
                    'id'   => $blockId,
                    'name' => $data['name'],
                ];
            }
        }

        return [
            'type'   => $type,
            'name'   => BlockModel::model()->getTypeName($type),
            'blocks' => $filteredBlocks,
        ];
    }

    /**
     * Gets record blocks
     *
     * @return array
     */
    private function _getRecordBlocks()
    {
        $filteredBlocks = [];

        $cloneMap = [];
        foreach ($this->_blocks as $blockId => $data) {
            if ($data['type'] !== BlockModel::TYPE_RECORD_CLONE) {
                continue;
            }

            $recordBlockId = RecordCloneModel::model()
                ->set([RecordCloneModel::PK_FIELD => $data['contentId']])
                ->getRecordBlockId();

            $cloneMap[$recordBlockId][] = [
                'id'        => $blockId,
                'name'      => $data['name'],
                'contentId' => $data['contentId'],
            ];
        }

        foreach ($this->_blocks as $blockId => $data) {
            if ($data['type'] !== BlockModel::TYPE_RECORD) {
                continue;
            }

            $children = [];
            if (array_key_exists($blockId, $cloneMap) === true) {
                $children = $cloneMap[$blockId];
            }

            $filteredBlocks[] = [
                'id'       => $blockId,
                'name'     => $data['name'],
                'children' => $children
            ];
        }

        return $filteredBlocks;
    }
}
