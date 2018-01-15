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
 * @var bool     $isUser
 * @var array    $generatedCss
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
        rel="stylesheet/less"
        type="text/css"
        href="/less/<?php echo $fileName; ?>.less"
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

<?php if (isset($less) === true && count($less) > 0) { ?>
    <script>
        less = {
            logLevel: 0
        };
    </script>
    <script src="/js/<?php echo 'lib/less.min.js'; ?>"></script>
<?php } ?>
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

<?php echo $content; ?>

<div id="ajax-wrapper"></div>

<script>
    window.jQuery(document).ready(function() {
        window.TestS.setLanguage(<?php echo $language; ?>);
        window.TestS.setToken("<?php echo $token; ?>");
        <?php foreach ($errorMessages as $key => $value) { ?>
            TestS.Components.Errors.set(
                "<?php echo $key; ?>", "<?php echo $value; ?>"
            );
        <?php } ?>
    });
</script>

<!--<script>-->
<!--    new TestS.Form.Text(-->
<!--        {-->
<!--            appendTo: $("body"),-->
<!--            placeholder: "aaaa",-->
<!--            value: "32131"-->
<!--        }-->
<!--    );-->
<!--</script>-->

</body>
</html>
