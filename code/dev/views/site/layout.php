<?php

/**
 * Variables
 *
 * @var string   $title
 * @var string   $keywords
 * @var string   $description
 * @var string[] $css
 * @var string[] $less
 * @var string[] $js
 * @var string   $content
 * @var integer  $version
 * @var string   $templates
 * @var integer  $language
 *
 * phpcs:disable Generic.Files.InlineHTML
 */
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $title; ?></title>
    <meta name="keywords" content="<?php echo $keywords; ?>"/>
    <meta name="description" content="<?php echo $description; ?>"/>
    <link rel="shortcut icon" href="/img/favicon.ico"/>
    <?php
    if (isset($css) === true) {
        foreach ($css as $fileName) {
            ?>
            <link
                rel="stylesheet"
                type="text/css"
                href="/css/<?php echo $fileName; ?>.css?<?php echo $version; ?>"
            />
            <?php
        }
    }
    ?>

    <?php
    if (isset($less) === true) {
        foreach ($less as $fileName) {
            ?>
            <link
                rel="stylesheet"
                type="text/css"
                href="/dev/less.php?name=<?php echo $fileName; ?>"
            />
            <?php
        }
    }
    ?>

    <?php
    if (isset($js) === true) {
        foreach ($js as $fileName) {
            ?>
            <script src="/js/<?php echo $fileName; ?>.js?<?php echo $version; ?>"></script>
            <?php
        }
    }
    ?>

    <script>
        window.ss.system.App.setLanguage(<?php echo $language; ?>);
    </script>
</head>
<body>

<?php echo $content; ?>

<div id="ajax-wrapper"></div>

<?php echo $templates; ?>

</body>
</html>
