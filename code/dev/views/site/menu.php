<?php
/**
 * Variables
 *
 * @var array $menu
 */
?>
<ul>
    <?php foreach ($menu as $item) { ?>
        <li>
            <a href="<?php echo $item['uri']; ?>">
                <?php echo $item['name']; ?>
            </a>
        </li>
    <?php } ?>
</ul>
