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
 * @var string   $token
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
        <script>
            less = {
                logLevel: 0
            };
        </script>
        <script src="/js/<?= "lib/less.min.js" ?>"></script>
    <?php } ?>
</head>
<body>

<?= $content; ?>

<div id="ajax-wrapper"></div>

<script>
    window.jQuery(document).ready(function() {
        window.TestS.setLanguage(<?= $language ?>);
        window.TestS.setToken("<?= $token ?>");
        <?php foreach ($errorMessages as $key => $value) { ?>
            TestS.Validator.Errors.set("<?= $key ?>", "<?= $value ?>");
        <?php } ?>
    });
</script>

<style>
    .block {
        width: 10%;
        border: 1px solid #ccc;
        display: inline-block;
        vertical-align: top;
    }

    .test {
        background: #eee;
        height: 100px;

    }

    .test:hover {
        box-shadow: 1px 1px 1px 1px rgba(0,0,0,0.3);
    }
</style>

<div class="block">
    <div class="test"></div>
</div>
<div class="block">
    1
</div>
<div class="block">
    1
</div>
<div class="block">
    1
</div>

</body>
</html>