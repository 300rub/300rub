<?php

/**
 * Variables
 *
 * @var int                                          $blockId
 * @var \ss\models\blocks\image\ImageInstanceModel[] $images
 */

echo sprintf('<div class="block-%s">', $blockId);

foreach ($images as $image) {
    echo sprintf(
        '<img src="%s" alt="%s" title="%s" />',
        $image->get('viewFileModel')->getUrl(),
        $image->get('alt'),
        $image->get('alt')
    );
}

echo '</div>';

//<div>
//  <div style="text-align: center;">
//<img src="https://html-online.com/editor/images/templates2.jpg"  style="margin: 50px;">
//  </div>
//   <div style="text-align: center;">
//<img src="https://html-online.com/editor/images/templates2.jpg" style="margin: 50px;">
//       </div>
//</div>