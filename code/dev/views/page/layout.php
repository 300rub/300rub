<?php

/**
 * Variables
 *
 * @var string   $title
 * @var string   $keywords
 * @var string   $description
 * @var string[] $css
 * @var string   $less
 * @var string[] $js
 * @var string   $content
 * @var int      $language
 * @var array    $errorMessages
 * @var string   $token
 * @var string   $sectionId
 * @var bool     $isUser
 * @var array    $generatedCss
 * @var array    $generatedJs
 * @var integer  $version
 * @var string   $headerCode
 * @var string   $bodyTopCode
 * @var string   $bodyBottomCode
 * @var string   $templates
 * @var bool     $isBlockSection
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

<?php if (isset($less) === true && $less !== null) { ?>
    <link
        rel="stylesheet"
        type="text/css"
        href="/dev/less.php?type=<?php echo $less; ?>"
    />
<?php } ?>
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
        echo sprintf(
            '<script src="/js/%s.js?%s"></script>',
            $fileName,
            $version
        );
    }
}
?>
    <script>
        window.ss.system.App.setLanguage(<?php echo $language; ?>);
        window.ss.system.App.setToken("<?php echo $token; ?>");
        window.ss.system.App.setSectionId(<?php echo $sectionId; ?>);

        <?php if (isset($isBlockSection) === true && $isBlockSection === true) { ?>
            window.ss.system.App.setIsBlockSection(true);
        <?php } ?>

        <?php foreach ($errorMessages as $key => $value) { ?>
        ss.components.Error.set(
            "<?php echo $key; ?>", "<?php echo $value; ?>"
        );
        <?php } ?>

        $(document).ready(function(){
            //new ss.window.section.Structure(4);
        });
    </script>

    <?php echo $headerCode; ?>
</head>
<body>

<?php echo $bodyTopCode; ?>

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
    include __DIR__ . '/../test/test.php';
}

echo $templates;

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

<?php echo $bodyBottomCode; ?>

</body>
</html>
