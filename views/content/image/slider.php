<?php

/**
 * Variables
 *
 * @var int $blockId
 * @var \ss\models\blocks\image\ImageInstanceModel[] $images
 */

echo sprintf('<div class="block-%s">', $blockId);

//foreach ($images as $image) {
//    echo sprintf(
//        '<a data-fancybox="image-group-%s" href="%s"><img src="%s" alt="%s" title="%s" /></a>',
//        $image->get('imageGroupId'),
//        $image->get('viewFileModel')->getUrl(),
//        $image->get('thumbFileModel')->getUrl(),
//        $image->get('alt'),
//        $image->get('alt')
//    );
//}
?>

<div class="cs3-wrap cs3-skin-no">
    <div class="cs3 cs3-no">
        <?php
        foreach ($images as $image) {
            echo sprintf(
                '<div class="cs3-slide"><img src="%s" width="600" height="200"></div>',

                $image->get('viewFileModel')->getUrl(),
                $image->get('thumbFileModel')->getUrl()
            );
        }
        ?>
      <div class="cs3-slide-prev"></div>
      <div class="cs3-slide-next"></div>
      <div class="cs3-pagination-wrap">
        <div class="cs3-pagination"></div>
      </div>
    </div>
  </div>

<script>
    $('.cs3-no').cs3({
        pagination : {
            container : '.cs3-no .cs3-pagination'
        },
        navigation : {
            next : '.cs3-no .cs3-slide-next',
            prev : '.cs3-no .cs3-slide-prev'
        }
    });
</script>
<?php
echo '</div>';
