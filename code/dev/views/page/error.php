<?php

/**
 * Variables
 *
 * @var string   $code
 * @var string   $message
 * @var string   $file
 * @var integer  $line
 * @var array    $backtrace
 * @var string[] $css
 * @var string[] $less
 * @var integer  $version
 *
 * phpcs:disable Generic.Files.InlineHTML
 */
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $code; ?> <?php echo $message; ?></title>
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
</head>
<body>

<div class="container">
    <h1><?php echo $code; ?></h1>
    <div class="content"><?php echo $message; ?></div>

    <?php if (APP_ENV === ENV_DEV) { ?>
        <div class="content">
            <?php echo $file; ?> (<?php echo $line; ?>)
        </div>
        <div class="content">
            <?php foreach ($backtrace as $key => $value) { ?>
                <div>
                    #<?php echo $key; ?>
                    <?php echo $value['file']; ?>
                    (<?php echo $value['line']; ?>)
                </div>
            <?php } ?>
        </div>
    <?php } ?>
</div>

</body>
</html>
