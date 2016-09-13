<?php

use models\DesignImageSliderModel;

return [
    // image_1
    1 => [
        "design_block_id"             => 15,
        "effect"                      => 0,
        "is_auto_play"                => 0,
        "play_speed"                  => 0,
        "navigation_design_block_id"  => 16,
        "navigation_alignment"        => 0,
        "description_design_block_id" => 17,
        "description_alignment"       => 0,
    ],
    // image_2
    2 => [
        "design_block_id"             => 21,
        "effect"                      => 0,
        "is_auto_play"                => 0,
        "play_speed"                  => 0,
        "navigation_design_block_id"  => 22,
        "navigation_alignment"        => 0,
        "description_design_block_id" => 23,
        "description_alignment"       => 0,
    ],
    // image_3 active
    3 => [
        "design_block_id"             => 27,
        "effect"                      => 0,
        "is_auto_play"                => 0,
        "play_speed"                  => 0,
        "navigation_design_block_id"  => 28,
        "navigation_alignment"        => DesignImageSliderModel::NAVIGATION_ALIGNMENT_NONE,
        "description_design_block_id" => 29,
        "description_alignment"       => DesignImageSliderModel::DESCRIPTION_ALIGNMENT_NONE,
    ],
    // image_4
    4 => [
        "design_block_id"             => 33,
        "effect"                      => 0,
        "is_auto_play"                => 0,
        "play_speed"                  => 0,
        "navigation_design_block_id"  => 34,
        "navigation_alignment"        => 0,
        "description_design_block_id" => 35,
        "description_alignment"       => 0,
    ],
    // image_5
    5 => [
        "design_block_id"             => 39,
        "effect"                      => 0,
        "is_auto_play"                => 0,
        "play_speed"                  => 0,
        "navigation_design_block_id"  => 40,
        "navigation_alignment"        => 0,
        "description_design_block_id" => 41,
        "description_alignment"       => 0,
    ],
    // image_6 active
    6 => [
        "design_block_id"             => 45,
        "effect"                      => 1,
        "is_auto_play"                => 1,
        "play_speed"                  => 5,
        "navigation_design_block_id"  => 46,
        "navigation_alignment"        => DesignImageSliderModel::DEFAULT_NAVIGATION_ALIGNMENT,
        "description_design_block_id" => 47,
        "description_alignment"       => DesignImageSliderModel::DEFAULT_DESCRIPTION_ALIGNMENT,
    ],
];