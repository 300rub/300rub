<?php
/**
 * Variables
 *
 * @var array $breadcrumbs
 *
 * phpcs:disable Generic.Files.InlineHTML
 */
?>
<ul class="breadcrumbs">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <?php if (array_key_exists('uri', $breadcrumb) === true) { ?>
            <li>
                <a href="<?php echo $breadcrumb['uri']; ?>">
                    <?php echo $breadcrumb['name']; ?>
                </a>
                <span class="separator">/</span>
            </li>
        <?php } ?>

        <?php if (array_key_exists('uri', $breadcrumb) === false) { ?>
            <li class="active">
                <?php echo $breadcrumb['name']; ?>
            </li>
        <?php } ?>
    <?php } ?>
    <div class="clear"></div>
</ul>
