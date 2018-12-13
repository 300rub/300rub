<?php

namespace ss\controllers\_abstract;

use ss\application\App;
use ss\models\blocks\block\BlockModel;
use ss\models\user\UserEventModel;

/**
 * Abstract class for working with controllers
 */
abstract class AbstractBlockController extends AbstractController
{

    /**
     * Writes block created event
     *
     * @param string     $category Category
     * @param BlockModel $block    Block model
     *
     * @return AbstractBlockController
     */
    protected function writeBlockCreatedEvent($category, $block)
    {
        App::getInstance()->getUser()->writeEvent(
            $category,
            UserEventModel::TYPE_ADD,
            sprintf(
                App::getInstance()->getLanguage()->getMessage(
                    'event',
                    'blockCreatedEventMask'
                ),
                $block->get('name')
            )
        );

        return $this;
    }

    /**
     * Writes block duplicated event
     *
     * @param string     $category Category
     * @param BlockModel $block    Block model
     *
     * @return AbstractBlockController
     */
    protected function writeBlockDuplicatedEvent($category, $block)
    {
        App::getInstance()->getUser()->writeEvent(
            $category,
            UserEventModel::TYPE_ADD,
            sprintf(
                App::getInstance()->getLanguage()->getMessage(
                    'event',
                    'blockDuplicatedEventMask'
                ),
                $block->get('name')
            )
        );

        return $this;
    }

    /**
     * Writes block deleted event
     *
     * @param string     $category Category
     * @param BlockModel $block    Block model
     *
     * @return AbstractBlockController
     */
    protected function writeBlockDeletedEvent($category, $block)
    {
        App::getInstance()->getUser()->writeEvent(
            $category,
            UserEventModel::TYPE_DELETE,
            sprintf(
                App::getInstance()->getLanguage()->getMessage(
                    'event',
                    'blockDeletedEventMask'
                ),
                $block->get('name')
            )
        );

        return $this;
    }

    /**
     * Writes block settings updated event
     *
     * @param string     $category Category
     * @param BlockModel $oldBlock Old block model
     * @param BlockModel $newBlock New block model
     *
     * @return AbstractBlockController
     */
    protected function writeBlockSettingsUpdatedEvent(
        $category,
        $oldBlock,
        $newBlock
    ) {
        if ($oldBlock->get('name') === $newBlock->get('name')) {
            App::getInstance()->getUser()->writeEvent(
                $category,
                UserEventModel::TYPE_EDIT,
                sprintf(
                    App::getInstance()->getLanguage()->getMessage(
                        'event',
                        'blockSettingsUpdatedEventMask'
                    ),
                    $oldBlock->get('name')
                )
            );

            return $this;
        }

        App::getInstance()->getUser()->writeEvent(
            $category,
            UserEventModel::TYPE_EDIT,
            sprintf(
                App::getInstance()->getLanguage()->getMessage(
                    'event',
                    'blockSettingsUpdatedNameChangedEventMask'
                ),
                $oldBlock->get('name'),
                $newBlock->get('name')
            )
        );

        return $this;
    }

    /**
     * Writes block content changed event
     *
     * @param string     $category Category
     * @param BlockModel $block    Block model
     *
     * @return AbstractBlockController
     */
    protected function writeBlockContentChangedEvent($category, $block)
    {
        App::getInstance()->getUser()->writeEvent(
            $category,
            UserEventModel::TYPE_EDIT,
            sprintf(
                App::getInstance()->getLanguage()->getMessage(
                    'event',
                    'blockContentChangedEventMask'
                ),
                $block->get('name')
            )
        );

        return $this;
    }

    /**
     * Write block design changed event
     *
     * @param string     $category Category
     * @param BlockModel $block    Block model
     *
     * @return AbstractBlockController
     */
    protected function writeBlockDesignChangedEvent($category, $block)
    {
        App::getInstance()->getUser()->writeEvent(
            $category,
            UserEventModel::TYPE_EDIT,
            sprintf(
                App::getInstance()->getLanguage()->getMessage(
                    'event',
                    'blockDesignChangedEventMask'
                ),
                $block->get('name')
            )
        );

        return $this;
    }
}
