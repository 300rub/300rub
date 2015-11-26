<?php

use system\web\Language;
use system\App;

/**
 * @var \controllers\SectionController $this
 * @var string                         $content
 */
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Site</title>
	<meta name="keywords" content=""/>
	<meta name="description" content=""/>

	<script src="/js/lib/jquery.min.js"></script>

	<script>
		var LANG = "<?= Language::getActiveAlias() ?>";
	</script>

	<link rel="stylesheet/less" type="text/css" href="/css/less.less" />

	<?php if (App::web()->user !== null) { ?>
		<link href='/css/lib/gridstack.min.css' rel='stylesheet' type='text/css'>
		<link href='/css/lib/colorpicker/jquery.colorpicker.css' rel='stylesheet' type='text/css'>
	<?php } ?>

	<script src="/js/lib/less.min.js" type="text/javascript"></script>

	<script src="/js/core.js"></script>
	<script src="/js/js.js"></script>

	<?php if (App::web()->user !== null) { ?>
		<script src="/js/lib/jquery-ui.min.js"></script>
		<script src="/js/lib/lodash.min.js"></script>
		<script src="/js/lib/gridstack.min.js"></script>
		<script src="/js/lib/jquery.colorpicker.js"></script>
		<script src="/js/lib/tinymce/tinymce.jquery.min.js"></script>
	<?php } ?>
</head>
<body>

<div id="wrapper">
	<?php echo $content; ?>
</div>

<?php if (App::web()->user === null) { ?>
	<a href="#" id="login-button">Вход</a>
<?php } else { ?>
	<?php require(__DIR__ . "/../section/panel_buttons.php"); ?>
	<a href="#" id="logout-button"></a>
<?php } ?>

<div id="ajax-wrapper"></div>

<div id="templates">
	<?php require(__DIR__ . "/../templates/window.php"); ?>
	<?php require(__DIR__ . "/../templates/loader.php"); ?>
	<?php require(__DIR__ . "/../templates/forms.php"); ?>
	<?php if (App::web()->user !== null) { ?>
		<?php require(__DIR__ . "/../templates/panel.php"); ?>
		<?php require(__DIR__ . "/../templates/grid.php"); ?>
		<?php require(__DIR__ . "/../design/text_forms.php"); ?>
		<?php require(__DIR__ . "/../design/block_forms.php"); ?>
	<?php } ?>
	<?php require(__DIR__ . "/../error/messages.php"); ?>
</div>

</body>
</html>