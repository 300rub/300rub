<?php

namespace ss\controllers\_abstract;

use ss\application\App;
use ss\models\blocks\block\BlockModel;

/**
 * Abstract class for working with controllers
 */
abstract class AbstractBlockController extends AbstractController
{

    /**
     * Gets block created event
     *
     * @param BlockModel $block
     *
     * @return string
     */
    protected function getBlockCreatedEvent($block)
    {
        return sprintf(
            App::getInstance()->getLanguage()->getMessage(
                'event',
                'blockCreatedEventMask'
            ),
            $block->get('name')
        );
    }

    /**
     * Gets block duplicated event
     *
     * @param BlockModel $block
     *
     * @return string
     */
    protected function getBlockDuplicatedEvent($block)
    {
        return sprintf(
            App::getInstance()->getLanguage()->getMessage(
                'event',
                'blockDuplicatedEventMask'
            ),
            $block->get('name')
        );
    }

    /**
     * Gets block deleted event
     *
     * @param BlockModel $block
     *
     * @return string
     */
    protected function getBlockDeletedEvent($block)
    {
        return sprintf(
            App::getInstance()->getLanguage()->getMessage(
                'event',
                'blockDeletedEventMask'
            ),
            $block->get('name')
        );
    }

    /**
     * Gets block settings updated event
     *
     * @param BlockModel $oldBlock
     * @param BlockModel $newBlock
     *
     * @return string
     */
    protected function getBlockSettingsUpdatedEvent($oldBlock, $newBlock)
    {
        if ($oldBlock->get('name') === $newBlock->get('name')) {
            return sprintf(
                App::getInstance()->getLanguage()->getMessage(
                    'event',
                    'blockSettingsUpdatedEventMask'
                ),
                $oldBlock->get('name')
            );
        }

        return sprintf(
            App::getInstance()->getLanguage()->getMessage(
                'event',
                'blockSettingsUpdatedNameChangedEventMask'
            ),
            $oldBlock->get('name'),
            $newBlock->get('name')
        );
    }

    /**
     * Gets block content changed event
     *
     * @param BlockModel $block
     *
     * @return string
     */
    protected function getBlockContentChangedEvent($block)
    {
        return sprintf(
            App::getInstance()->getLanguage()->getMessage(
                'event',
                'blockContentChangedEventMask'
            ),
            $block->get('name')
        );
    }

    /**
     * Gets block design changed event
     *
     * @param BlockModel $block
     *
     * @return string
     */
    protected function getBlockDesignChangedEvent($block)
    {
        return sprintf(
            App::getInstance()->getLanguage()->getMessage(
                'event',
                'blockDesignChangedEventMask'
            ),
            $block->get('name')
        );
    }
}
