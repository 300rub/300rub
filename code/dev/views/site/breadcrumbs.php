<?php
/**
 * @var array $breadcrumbs
 */
?>
<ul>
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <?php if (array_key_exists('uri', $breadcrumb) === true) { ?>
            <li>
                <a href="<?php echo $breadcrumb['uri']; ?>">
                    <?php echo $breadcrumb['label']; ?>
                </a>
            </li>
        <?php } ?>

        <?php if (array_key_exists('uri', $breadcrumb) === false) { ?>
            <li class="active">
                <?php echo $breadcrumb['label']; ?>
            </li>
        <?php } ?>
    <?php } ?>
</ul>