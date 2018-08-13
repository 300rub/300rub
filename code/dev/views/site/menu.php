<?php
/**
 * Variables
 *
 * @var array $menu
 */
?>
<ul class="menu">
    <?php foreach ($menu as $item) {
        ?><li<?php if ($item['isActive'] === true) { ?> class="active"<?php } ?>>
            <a href="<?php echo $item['uri']; ?>">
                <span><?php echo $item['name']; ?></span>
            </a>
        </li><?php } ?>
</ul>
