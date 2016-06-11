<?php

use application\App;
use components\Language;

/**
 * @var \controllers\SectionController $this
 * @var string                         $content
 */

$staticMap = require(__DIR__ . "/../../config/static_map.php");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Site</title>
	<meta name="keywords" content=""/>
	<meta name="description" content=""/>

	<?php if (App::web()->config->isDebug) { ?>
		<?php foreach ($staticMap["common"]["css"] as $fileName) { ?>
			<link rel="stylesheet" type="text/css" href="/css/<?= $fileName ?>" />
		<?php } ?>
		<?php foreach ($staticMap["common"]["less"] as $fileName) { ?>
			<link rel="stylesheet/less" type="text/css" href="/css/<?= $fileName ?>" />
		<?php } ?>
	<?php } else { ?>
		<link rel='stylesheet' type='text/css' href='/css/<?= "common.min.css" ?>' />
	<?php } ?>

	<?php if (App::web()->user !== null) { ?>
		<?php if (App::web()->config->isDebug) { ?>
			<?php foreach ($staticMap["admin"]["css"] as $fileName) { ?>
				<link rel="stylesheet" type="text/css" href="/css/<?= $fileName ?>" />
			<?php } ?>
			<?php foreach ($staticMap["admin"]["less"] as $fileName) { ?>
				<link rel="stylesheet/less" type="text/css" href="/css/<?= $fileName ?>" />
			<?php } ?>
		<?php } else { ?>
			<link rel='stylesheet' type='text/css' href='/css/<?= "admin.min.css" ?>' />
		<?php } ?>
	<?php } ?>

	<?php if (App::web()->config->isDebug) { ?>
		<?php foreach ($staticMap["common"]["js"] as $fileName) { ?>
			<script src="/js/<?= $fileName ?>"></script>
		<?php } ?>
	<?php } else { ?>
		<script src="/js/<?= "common.min.js" ?>"></script>
	<?php } ?>

	<?php if (App::web()->user !== null) { ?>
		<?php if (App::web()->config->isDebug) { ?>
			<?php foreach ($staticMap["admin"]["js"] as $fileName) { ?>
				<script src="/js/<?= $fileName ?>"></script>
			<?php } ?>
		<?php } else { ?>
			<script src="/js/<?= "admin.min.js" ?>"></script>
		<?php } ?>
	<?php } ?>

	<script>
		window.Core.language = "<?= Language::getActiveAlias() ?>";
	</script>

	<?php if (App::web()->config->isDebug) { ?>
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

<div id="wrapper">
	<?php echo $content; ?>
</div>

<?php if (App::web()->user === null) { ?>
	<a id="login-button">Вход</a>
<?php } else { ?>
	<?php require("admin_bottom_container.php"); ?>
<?php } ?>

<div id="ajax-wrapper"></div>

<div id="templates">
	<?php require(__DIR__ . "/../templates/templates.php"); ?>
</div>

</body>
</html>