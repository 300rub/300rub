<?php

namespace ss\controllers\section;

use ss\application\components\user\Operation;
use ss\controllers\_abstract\AbstractController;
use ss\models\sections\GridLineModel;
use ss\models\sections\GridModel;

/**
 * Updates section structure
 */
class UpdateStructureController extends AbstractController
{

    /**
     * New line IDs
     *
     * @var int[]
     */
    private $_newLineIds = [];

    /**
     * Current lines
     *
     * @var GridLineModel[]
     */
    private $_currentLines = [];

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
                'id'        => [self::TYPE_INT, self::NOT_EMPTY],
                'structure' => [self::TYPE_ARRAY],
            ]
        );

        $this
            ->_setNewLineIds()
            ->_setCurrentLines()
            ->_deleteExtraLines()
            ->_deleteExtraGrids()
            ->_updateStructure();

        return $this->getSimpleSuccessResult();
    }

    /**
     * Sets new line IDs
     *
     * @return UpdateStructureController
     */
    private function _setNewLineIds()
    {
        $this->_newLineIds = [];

        foreach ($this->get('structure') as $line) {
            if ($line['id'] === 0) {
                continue;
            }

            $this->_newLineIds[] = $line['id'];
        }

        return $this;
    }

    /**
     * Sets current lines
     *
     * @return UpdateStructureController
     */
    private function _setCurrentLines()
    {
        $this->_currentLines = [];

        $currentLines = GridLineModel::model()
            ->bySectionId($this->get('id'))
            ->findAll();

        foreach ($currentLines as $currentLine) {
            $this->_currentLines[$currentLine->getId()] = $currentLine;
        }

        return $this;
    }

    /**
     * Deletes old extra lines
     *
     * @return UpdateStructureController
     */
    private function _deleteExtraLines()
    {
        foreach ($this->_currentLines as $lineId => $lineModel) {
            if (in_array($lineId, $this->_newLineIds) === true) {
                continue;
            }

            $lineModel->delete();
            unset($this->_currentLines[$lineId]);
        }

        return $this;
    }

    /**
     * Updates structure
     *
     * @return UpdateStructureController
     */
    private function _updateStructure()
    {
        $sort = 10;

        foreach ($this->get('structure') as $line) {
            $lineModel = $this->_getLineById($line['id']);
            $lineModel->set(['sort' => $sort]);
            $lineModel->save();

            foreach ($line['grids'] as $grid) {
                $gridModel = new GridModel();
                $gridModel->set(
                    [
                        'gridLineId' => $lineModel->getId(),
                        'blockId'    => $grid['blockId'],
                        'x'          => $grid['x'],
                        'y'          => $grid['y'],
                        'width'      => $grid['width'],
                    ]
                );
                $gridModel->save();
            }

            $sort += 10;
        }

        return $this;
    }

    /**
     * Gets Line model
     *
     * @param int $lineId LineId
     *
     * @return GridLineModel
     */
    private function _getLineById($lineId)
    {
        $hasLine = array_key_exists($lineId, $this->_currentLines);
        if ($hasLine === true) {
            return $this->_currentLines[$lineId];
        }

        $lineModel = new GridLineModel();
        $lineModel->set(['sectionId' => $this->get('id')]);
        return $lineModel;
    }

    /**
     * Deletes old grids
     *
     * @return UpdateStructureController
     */
    private function _deleteExtraGrids()
    {
        foreach (array_keys($this->_currentLines) as $lineId) {
            GridModel::model()->delete(
                'gridLineId = :gridLineId',
                [
                    'gridLineId' => $lineId
                ]
            );
        }

        return $this;
    }
}
