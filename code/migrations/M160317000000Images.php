<?php

namespace ss\migrations;

use ss\migrations\_abstract\AbstractMigration;

/**
 * Creates image tables
 */
class M160317000000Images extends AbstractMigration
{

    /**
     * Applies migration
     *
     * @return void
     */
    protected function up()
    {
        $this
            ->_createDesignImageAlbum()
            ->_createDesignImageSimple()
            ->_createDesignImageZooms()
            ->_createDesignImageSliders()
            ->_createImages()
            ->_createImageGroups()
            ->_createImageInstances();
    }

    /**
     * Creates designImageAlbums table
     *
     * @return M160317000000Images
     */
    private function _createDesignImageAlbum()
    {
        return $this->
        createTable(
            'designImageAlbums',
            [
                'id'                     => self::TYPE_PK,
                'containerDesignBlockId' => self::TYPE_FK,
                'imageDesignBlockId'     => self::TYPE_FK,
                'nameDesignBlockId'      => self::TYPE_FK,
                'nameDesignTextId'       => self::TYPE_FK,
            ]
        )
            ->createForeignKey(
                'designImageAlbums',
                'containerDesignBlockId',
                'designBlocks'
            )
            ->createForeignKey(
                'designImageAlbums',
                'imageDesignBlockId',
                'designBlocks'
            )
            ->createForeignKey(
                'designImageAlbums',
                'nameDesignBlockId',
                'designBlocks'
            )
            ->createForeignKey(
                'designImageAlbums',
                'nameDesignTextId',
                'designTexts'
            );
    }

    /**
     * Creates designImageSimple table
     *
     * @return M160317000000Images
     */
    private function _createDesignImageSimple()
    {
        return $this->
            createTable(
                'designImageSimple',
                [
                    'id'                       => self::TYPE_PK,
                    'containerDesignBlockId'   => self::TYPE_FK,
                    'imageDesignBlockId'       => self::TYPE_FK,
                    'descriptionDesignBlockId' => self::TYPE_FK,
                    'descriptionDesignTextId'  => self::TYPE_FK,
                    'useDescription'           => self::TYPE_BOOL,
                    'alignment'                => self::TYPE_TINYINT_UNSIGNED,
                ]
            )
            ->createForeignKey(
                'designImageSimple',
                'containerDesignBlockId',
                'designBlocks'
            )
            ->createForeignKey(
                'designImageSimple',
                'imageDesignBlockId',
                'designBlocks'
            )
            ->createForeignKey(
                'designImageSimple',
                'descriptionDesignBlockId',
                'designBlocks'
            )
            ->createForeignKey(
                'designImageSimple',
                'descriptionDesignTextId',
                'designTexts'
            );
    }

    /**
     * Creates designImageZooms table
     *
     * @return M160317000000Images
     */
    private function _createDesignImageZooms()
    {
        return $this
            ->createTable(
                'designImageZooms',
                [
                    'id'                   => self::TYPE_PK,
                    'designBlockId'        => self::TYPE_FK,
                    'effect'               => self::TYPE_TINYINT_UNSIGNED,
                ]
            )
            ->createForeignKey(
                'designImageZooms',
                'designBlockId',
                'designBlocks'
            );
    }

    /**
     * Creates designImageSliders table
     *
     * @return M160317000000Images
     */
    private function _createDesignImageSliders()
    {
        return $this
            ->createTable(
                'designImageSliders',
                [
                    'id'                        => self::TYPE_PK,
                    'arrowDesignTextId'         => self::TYPE_FK,
                    'bulletDesignBlockId'       => self::TYPE_FK,
                    'bulletActiveDesignBlockId' => self::TYPE_FK,
                    'descriptionDesignBlockId'  => self::TYPE_FK,
                    'descriptionDesignTextId'   => self::TYPE_FK,
                    'isFullWidth'               => self::TYPE_BOOL,
                    'hasDescription'            => self::TYPE_BOOL,
                    'effect'                    => self::TYPE_TEXT,
                    'hasAutoPlay'               => self::TYPE_BOOL,
                    'playSpeed'                 => self::TYPE_TINYINT_UNSIGNED,
                ]
            )
            ->createForeignKey(
                'designImageSliders',
                'arrowDesignTextId',
                'designTexts'
            )
            ->createForeignKey(
                'designImageSliders',
                'bulletDesignBlockId',
                'designBlocks'
            )
            ->createForeignKey(
                'designImageSliders',
                'bulletActiveDesignBlockId',
                'designBlocks'
            )
            ->createForeignKey(
                'designImageSliders',
                'descriptionDesignBlockId',
                'designBlocks'
            )
            ->createForeignKey(
                'designImageSliders',
                'descriptionDesignTextId',
                'designTexts'
            );
    }

    /**
     * Creates images table
     *
     * @return M160317000000Images
     */
    private function _createImages()
    {
        return $this
            ->createTable(
                'images',
                [
                    'id'                  => self::TYPE_PK,
                    'designBlockId'       => self::TYPE_FK,
                    'designImageAlbumId'  => self::TYPE_FK,
                    'designImageSliderId' => self::TYPE_FK,
                    'designImageZoomId'   => self::TYPE_FK,
                    'designImageSimpleId' => self::TYPE_FK,
                    'type'                => self::TYPE_TINYINT_UNSIGNED,
                    'autoCropType'        => self::TYPE_TINYINT_UNSIGNED,
                    'cropX'               => self::TYPE_INT_UNSIGNED,
                    'cropY'               => self::TYPE_INT_UNSIGNED,
                    'thumbAutoCropType'   => self::TYPE_TINYINT_UNSIGNED,
                    'thumbCropX'          => self::TYPE_SMALLINT_UNSIGNED,
                    'thumbCropY'          => self::TYPE_SMALLINT_UNSIGNED,
                    'useAlbums'           => self::TYPE_BOOL,
                ]
            )
            ->createForeignKey(
                'images',
                'designBlockId',
                'designBlocks'
            )
            ->createForeignKey(
                'images',
                'designImageAlbumId',
                'designImageAlbums'
            )
            ->createForeignKey(
                'images',
                'designImageSliderId',
                'designImageSliders'
            )
            ->createForeignKey(
                'images',
                'designImageZoomId',
                'designImageZooms'
            )
            ->createForeignKey(
                'images',
                'designImageSimpleId',
                'designImageSimple'
            );
    }

    /**
     * Creates imageGroups table
     *
     * @return M160317000000Images
     */
    private function _createImageGroups()
    {
        return $this
            ->createTable(
                'imageGroups',
                [
                    'id'                     => self::TYPE_PK,
                    'imageId'                => self::TYPE_FK,
                    'seoId'                  => self::TYPE_FK,
                    'containerDesignBlockId' => self::TYPE_FK,
                    'coverDesignBlockId'     => self::TYPE_FK,
                    'nameDesignBlockId'      => self::TYPE_FK,
                    'nameDesignTextId'       => self::TYPE_FK,
                    'sort'                   => self::TYPE_SMALLINT,
                ]
            )
            ->createForeignKey(
                'imageGroups',
                'imageId',
                'images',
                self::FK_CASCADE,
                self::FK_CASCADE
            )
            ->createForeignKey('imageGroups', 'seoId', 'seo')
            ->createForeignKey(
                'imageGroups',
                'containerDesignBlockId',
                'designBlocks'
            )
            ->createForeignKey(
                'imageGroups',
                'coverDesignBlockId',
                'designBlocks'
            )
            ->createForeignKey(
                'imageGroups',
                'nameDesignBlockId',
                'designBlocks'
            )
            ->createForeignKey(
                'imageGroups',
                'nameDesignTextId',
                'designTexts'
            )
            ->createIndex('imageGroups', 'sort');
    }

    /**
     * Creates imageInstances table
     *
     * @return M160317000000Images
     */
    private function _createImageInstances()
    {
        return $this
            ->createTable(
                'imageInstances',
                [
                    'id'             => self::TYPE_PK,
                    'imageGroupId'   => self::TYPE_FK_NULL,
                    'originalFileId' => self::TYPE_FK,
                    'viewFileId'     => self::TYPE_FK,
                    'thumbFileId'    => self::TYPE_FK,
                    'isCover'        => self::TYPE_BOOL,
                    'sort'           => self::TYPE_SMALLINT,
                    'alt'            => self::TYPE_TEXT,
                    'link'           => self::TYPE_TEXT,
                    'width'          => self::TYPE_SMALLINT_UNSIGNED,
                    'height'         => self::TYPE_SMALLINT_UNSIGNED,
                    'x1'             => self::TYPE_SMALLINT_UNSIGNED,
                    'y1'             => self::TYPE_SMALLINT_UNSIGNED,
                    'x2'             => self::TYPE_SMALLINT_UNSIGNED,
                    'y2'             => self::TYPE_SMALLINT_UNSIGNED,
                    'angle'          => self::TYPE_SMALLINT,
                    'flip'           => self::TYPE_TINYINT_UNSIGNED,
                    'thumbX1'        => self::TYPE_SMALLINT_UNSIGNED,
                    'thumbY1'        => self::TYPE_SMALLINT_UNSIGNED,
                    'thumbX2'        => self::TYPE_SMALLINT_UNSIGNED,
                    'thumbY2'        => self::TYPE_SMALLINT_UNSIGNED,
                    'thumbAngle'     => self::TYPE_SMALLINT,
                    'thumbFlip'      => self::TYPE_TINYINT_UNSIGNED,
                ]
            )
            ->createForeignKey(
                'imageInstances',
                'imageGroupId',
                'imageGroups',
                self::FK_CASCADE,
                self::FK_CASCADE
            )
            ->createForeignKey('imageInstances', 'originalFileId', 'files')
            ->createForeignKey('imageInstances', 'viewFileId', 'files')
            ->createForeignKey('imageInstances', 'thumbFileId', 'files')
            ->createIndex('imageInstances', 'isCover')
            ->createIndex('imageInstances', 'sort')
            ->createForeignKey(
                'designBlocks',
                'imageInstanceId',
                'imageInstances',
                self::FK_NULL,
                self::FK_NULL
            );
    }

    /**
     * SQL down
     *
     * @return void
     */
    protected function down()
    {
        $this
            ->dropTable('imageInstances')
            ->dropTable('imageGroups')
            ->dropTable('images')
            ->dropTable('designImageSliders')
            ->dropTable('designImageZooms')
            ->dropTable('designImageSimple')
            ->dropTable('designImageAlbums');
    }
}
