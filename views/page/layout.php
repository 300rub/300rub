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
 * @var bool     $isUser
 * @var array    $generatedCss
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

    <style><?php
        if ($isUser === false) {
            foreach ($generatedCss as $gCss) {
                echo $gCss;
            }
        }
    ?></style>

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

<?php
if ($isUser === true) {
    foreach ($generatedCss as $id => $gCss) {
        $styleMask = "<style>%s</style>";
        echo sprintf('<div id="%s">' . $styleMask . '</div>', $id, $gCss);
    }
}
?>

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

</body>
</html>