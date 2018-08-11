<?php
/**
 * @var array $menu
 */
?>
<ul>
    <?php foreach ($menu as $item) { ?>
        <li>
            <a href="<?php echo $item['uri']; ?>">
                <?php echo $item['label']; ?>
            </a>
        </li>
    <?php } ?>
</ul>