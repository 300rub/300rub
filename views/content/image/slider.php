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




<div id="jssor_1" style="position:relative;top:0px;left:0px;width:600px;height:200px;overflow:hidden;">
    <div data-u="slides" style="position:absolute;top:0px;left:0px;width:600px;height:200px;overflow:hidden;">

        <?php
        foreach ($images as $image) {
            echo sprintf(
                '<div><img data-u="image" src="%s" /></div>',
                $image->get('viewFileModel')->getUrl()
            );
        }
        ?>
    </div>
</div>
<script>
    var jssor_1_SlideshowTransitions = [
        { $Duration: 500, $Delay: 30, $Cols: 8, $Rows: 4, $Clip: 15, $SlideOut: true, $Formation: $JssorSlideshowFormations$.$FormationStraightStairs, $Assembly: 2049, $Easing: $Jease$.$OutQuad },
        { $Duration: 500, $Delay: 80, $Cols: 8, $Rows: 4, $Clip: 15, $SlideOut: true, $Easing: $Jease$.$OutQuad },
        { $Duration: 1000, x: -0.2, $Delay: 40, $Cols: 12, $SlideOut: true, $Formation: $JssorSlideshowFormations$.$FormationStraight, $Assembly: 260, $Easing: { $Left: $Jease$.$InOutExpo, $Opacity: $Jease$.$InOutQuad }, $Opacity: 2, $Outside: true, $Round: { $Top: 0.5 } },
        { $Duration: 2000, y: -1, $Delay: 60, $Cols: 15, $SlideOut: true, $Formation: $JssorSlideshowFormations$.$FormationStraight, $Easing: $Jease$.$OutJump, $Round: { $Top: 1.5 } },
        { $Duration: 1200, x: 0.2, y: -0.1, $Delay: 20, $Cols: 8, $Rows: 4, $Clip: 15, $During: { $Left: [0.3, 0.7], $Top: [0.3, 0.7] }, $Formation: $JssorSlideshowFormations$.$FormationStraightStairs, $Assembly: 260, $Easing: { $Left: $Jease$.$InWave, $Top: $Jease$.$InWave, $Clip: $Jease$.$OutQuad }, $Round: { $Left: 1.3, $Top: 2.5 } }
    ];

    var jssor_1_options = {
        $AutoPlay: 1,
        $SlideshowOptions: {
            $Class: $JssorSlideshowRunner$,
            $Transitions: jssor_1_SlideshowTransitions,
            $TransitionsOrder: 1
        },
        $ArrowNavigatorOptions: {
            $Class: $JssorArrowNavigator$
        },
        $BulletNavigatorOptions: {
            $Class: $JssorBulletNavigator$
        }
    };

    var jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);
</script>

<?php
echo '</div>';
