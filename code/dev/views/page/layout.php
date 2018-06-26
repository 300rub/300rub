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
 * @var int      $language
 * @var array    $errorMessages
 * @var string   $token
 * @var string   $sectionId
 * @var bool     $isUser
 * @var array    $generatedCss
 * @var array    $generatedJs
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
    <link rel="shortcut icon" href="/public/img/favicon.ico"/>
<?php
if (isset($css) === true) {
    foreach ($css as $fileName) {
?>
    <link
        rel="stylesheet"
        type="text/css"
        href="/css/<?php echo $fileName; ?>.css"
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
    <style>
<?php
if ($isUser === false) {
    foreach ($generatedCss as $gCss) {
        echo $gCss;
    }
}
?>
    </style>
<?php
if (isset($js) === true) {
    foreach ($js as $fileName) {
?>
    <script src="/js/<?php echo $fileName; ?>.js"></script>
<?php
    }
}
?>

    <script>
        window.ss.system.App.setLanguage(<?php echo $language; ?>);
        window.ss.system.App.setToken("<?php echo $token; ?>");
        window.ss.system.App.setSectionId(<?php echo $sectionId; ?>);
        <?php foreach ($errorMessages as $key => $value) { ?>
        ss.components.Error.set(
            "<?php echo $key; ?>", "<?php echo $value; ?>"
        );
        <?php } ?>
    </script>
</head>
<body>

<?php
if ($isUser === true) {
    foreach ($generatedCss as $id => $gCss) {
        $styleMask = '<style>%s</style>';
        echo sprintf('<div id="%s">' . $styleMask . '</div>', $id, $gCss);
    }
}
?>

<?php

if (array_key_exists('test', $_GET) === false) {
    echo $content;
}

if (array_key_exists('test', $_GET) === true) {
    require __DIR__ . '/../test/test.php';
}

?>

<?php
echo '<script>';

foreach ($generatedJs as $id => $gJs) {
    echo sprintf(
        '!function(){%s}();',
        $gJs
    );
}

echo '</script>';
?>

<div id="ajax-wrapper"></div>

</body>
</html>