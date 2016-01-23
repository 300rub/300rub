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
		<link rel="stylesheet/less" type="text/css" href="/css/admin.less" />
		<link href='/css/lib/gridstack.min.css' rel='stylesheet' type='text/css'>
		<link href='/css/lib/colorpicker/jquery.colorpicker.css' rel='stylesheet' type='text/css'>
	<?php } ?>

	<script>
		less = {
			async: true,
			env: 'development'
		};
	</script>
	<script src="/js/lib/less.min.js" type="text/javascript"></script>

	<script src="/js/core.js"></script>
	<script src="/js/functions.js"></script>
	<script src="/js/ajax.json.js"></script>
	<script src="/js/form.js"></script>
	<script src="/js/validator.js"></script>
	<script src="/js/window.js"></script>
	<script src="/js/window.login.js"></script>
	<script src="/js/handler.js"></script>

	<?php if (App::web()->user !== null) { ?>
		<script src="/js/lib/jquery-ui.min.js"></script>
		<script src="/js/lib/lodash.min.js"></script>
		<script src="/js/lib/gridstack.min.js"></script>
		<script src="/js/lib/jquery.colorpicker.js"></script>
		<script src="/js/lib/tinymce/tinymce.jquery.min.js"></script>
		<script src="/js/admin.js"></script>
		<script src="/js/panel.js"></script>
	<?php } ?>
</head>
<body>

<div id="wrapper">
	<?php echo $content; ?>
</div>

<?php if (App::web()->user === null) { ?>
	<a href="#" id="login-button">Вход</a>
<?php } else { ?>
	<div id="panel-buttons">
		<a
			href="#"
			data-action="section.panelList"
			data-handler="section"
			><span><?= Language::t("common", "Разделы") ?></span></a>

		<a
			href="#"
			data-action="block.panelList"
			data-handler="block"
			><span><?= Language::t("common", "Блоки") ?></span></a>
	</div>
	<a href="#" id="logout-button">Logout</a>
<?php } ?>

<div id="ajax-wrapper"></div>

<div id="templates">
	<?php require(__DIR__ . "/../templates/templates.php"); ?>
</div>

</body>
</html>