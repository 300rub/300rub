<?php

/**
 * @var string $menu
 * @var string $name
 * @var string $text
 * @var array  $childCategories
 */
?>

<?php echo $menu; ?>

<h1><?php echo $name; ?></h1>

<div><?php echo $text; ?></div>

<ul>
    <?php foreach ($childCategories as $childCategory) { ?>
        <li>
            <a href="<?php echo $childCategory['uri']; ?>">
                <?php echo $childCategory['name']; ?>
            </a>
        </li>
    <?php } ?>
</ul>
