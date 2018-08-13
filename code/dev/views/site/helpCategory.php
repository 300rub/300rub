<?php

/**
 * @var string $menu
 * @var string $breadcrumbs
 * @var string $name
 * @var string $text
 * @var array  $childCategories
 * @var array  $pages
 */
?>

<?php echo $menu; ?>

<?php echo $breadcrumbs; ?>

<h1><?php echo $name; ?></h1>

<div><?php echo $text; ?></div>

<?php if (count($childCategories) > 0) { ?>
    <ul>
        <?php foreach ($childCategories as $childCategory) { ?>
            <li>
                <a href="<?php echo $childCategory['uri']; ?>">
                    <?php echo $childCategory['name']; ?>
                </a>
            </li>
        <?php } ?>
    </ul>
<?php } ?>

<?php if (count($pages) > 0) { ?>
    <ul>
        <?php foreach ($pages as $page) { ?>
            <li>
                <a href="<?php echo $page['uri']; ?>">
                    <?php echo $page['name']; ?>
                </a>
            </li>
        <?php } ?>
    </ul>
<?php } ?>