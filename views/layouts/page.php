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

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

	<script>
		var LANG = "<?php echo Language::getActiveAlias(); ?>";
	</script>

	<link href='/css/fonts/myriad-pro.css' rel='stylesheet' type='text/css'>
	<link href='/css/css.css' rel='stylesheet' type='text/css'>
	<link href='/css/window.css' rel='stylesheet' type='text/css'>
	<link href='/css/form.css' rel='stylesheet' type='text/css'>
	<?php if (App::web()->user !== null) { ?>
		<link rel="stylesheet"
			  href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
		<link href='/css/lib/gridstack.min.css' rel='stylesheet' type='text/css'>
		<link href='/css/admin.css' rel='stylesheet' type='text/css'>
		<link href='/css/panel.css' rel='stylesheet' type='text/css'>
		<link href='/css/grid.css' rel='stylesheet' type='text/css'>
	<?php } ?>

	<script src="/js/Window.js"></script>
	<script src="/js/Form.js"></script>
	<script src="/js/Validator.js"></script>
	<script src="/js/js.js"></script>

	<?php if (App::web()->user !== null) { ?>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
		<script src="/js/lib/lodash.min.js"></script>
		<script src="/js/lib/gridstack.min.js"></script>
		<script src="/js/lib/jqColorPicker.min.js"></script>
		<script src="/js/Grid.js"></script>
		<script src="/js/Panel.js"></script>
		<script src="/js/Design.js"></script>
		<script src="/js/admin.js"></script>
	<?php } ?>
</head>
<body>

<div id="wrapper">
	<?php echo $content; ?>
</div>

<?php if (App::web()->user === null) { ?>
	<a href="#" id="login-button">Вход</a>
<?php } else { ?>
	<?php //require(__DIR__ . "/../section/panel_buttons.php"); ?>
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
	<?php } ?>
	<?php require(__DIR__ . "/../error/messages.php"); ?>
</div>

<button id="test">111</button>
<script>
	$(function () {
		$("#test").on("click", function() {
			$design = (new Design("text", 1)).get();
			$design.appendTo("#ajax-wrapper");
		});
	});
</script>

</body>
</html>