<?php

/**
 * Variables
 *
 * @var int $blockId
 * @var \ss\models\blocks\image\ImageInstanceModel[] $images
 * @var \ss\models\blocks\image\ImageModel           $image
 */

echo sprintf('<div class="block-%s">', $blockId);
?>


<div
    id="<?= sprintf('slider-%s', uniqid()) ?>"
    class="slider-container"
    style="position:relative;top:0px;left:0px;width:600px;height:200px;overflow:hidden;"
>
    <div
        data-u="slides"
        style="position:absolute;top:0px;left:0px;width:600px;height:200px;overflow:hidden;"
    >

        <?php
        foreach ($images as $imageInstance) {
            echo sprintf(
                '<div><img data-u="image" src="%s" /></div>',
                $imageInstance->get('viewFileModel')->getUrl()
            );
        }
        ?>
    </div>
</div>

<?php
echo '</div>';
