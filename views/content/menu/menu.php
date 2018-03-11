<?php

/**
 * Variables
 *
 * @var integer                                $blockId
 * @var integer                                $type
 * @var \ss\models\blocks\menu\DesignMenuModel $designMenuModel
 */

echo sprintf(
    '<div class="block-%s menu menu-%s">',
    $blockId,
    $type
);
?>

    <ul>
        <li><a href="#">Link</a></li>
        <li><a href="#">Link</a></li>
        <li><a href="#">Link</a></li>
        <ul>
            <li><a href="#">Link</a></li>
            <li><a href="#">Link</a></li>
            <ul>
                <li><a href="#">Link</a></li>
                <li><a href="#">Link</a></li>
                <ul>
                    <li><a href="#">Link</a></li>
                    <li><a href="#">Link</a></li>
                </ul>
            </ul>
        </ul>
    </ul>

<?php

echo '</div>';
