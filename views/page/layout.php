<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Site</title>
    <meta name="keywords" content=""/>
    <meta name="description" content=""/>

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
</head>
<body>

<?php echo $content; ?>

</body>
</html>