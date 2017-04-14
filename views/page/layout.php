<?php
/**
 * @var string   $title
 * @var string   $keywords
 * @var string   $description
 * @var string[] $css
 * @var string[] $less
 * @var string[] $js
 * @var string   $content
 * @var int      $language
 * @var array    $errorMessages
 */
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= $title ?></title>
    <meta name="keywords" content="<?= $keywords ?>"/>
    <meta name="description" content="<?= $description ?>"/>
   <?php if (isset($css)) { foreach ($css as $fileName) { ?>
        <link rel="stylesheet" type="text/css" href="/css/<?= $fileName ?>.css" />
    <?php } } ?>

    <?php if (isset($less)) { foreach ($less as $fileName) { ?>
        <link rel="stylesheet/less" type="text/css" href="/less/<?= $fileName ?>.less" />
    <?php } } ?>

    <?php if (isset($js)) { foreach ($js as $fileName) { ?>
        <script src="/js/<?= $fileName ?>.js"></script>
    <?php } } ?>

    <?php if (isset($less) && count($less) > 0) { ?>
        <script src="/js/<?= "lib/less.min.js" ?>"></script>
        <script>
            less = {
                async: true,
                env: 'development'
            };
        </script>
    <?php } ?>

    <script>
        window.jQuery(document).ready(function() {
            window.TestS.setLanguage(<?= $language ?>);
            <?php foreach ($errorMessages as $key => $value) { ?>
                TestS.Validator.Errors.set("<?= $key ?>", "<?= $value ?>");
            <?php } ?>
        });
    </script>
</head>
<body>

<?= $content; ?>

<div id="ajax-wrapper"></div>

</body>
</html>