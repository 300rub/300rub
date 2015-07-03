<?php

use system\web\Language;
use system\base\Validator;
use system\App;

/**
 * @var string $content
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
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
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
		<script src="/js/Grid.js"></script>
		<script src="/js/Panel.js"></script>
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
	<div id="panel-buttons">
		<a
			href="#"
			id="sections-button"
			data-name="sections"
			data-content="section/panelList"
			><span><?php echo Language::t("common", "Разделы"); ?></span></a>

		<a
			href="#"
			id="blocks-button"
			data-name="blocks"
			data-content="blocks/panelList"
			><span><?php echo Language::t("common", "Блоки"); ?></span></a>

		<a
			href="#"
			id="settings-button"
			data-name="settings"
			data-content="blocks/panelList"
			><span><?php echo Language::t("common", "Настройки"); ?></span></a>

		<a
			href="#"
			id="payment-button"
			data-name="payment"
			data-content="blocks/panelList"
			><span><?php echo Language::t("common", "Оплата"); ?></span></a>
	</div>

	<a href="#" id="logout-button"></a>
<?php } ?>

<div id="ajax-wrapper"></div>

<div id="templates">
	<div class="window">
		<form action="" method="post">
			<a href="#" class="close"></a>

			<div class="header"></div>
			<div class="container"></div>
			<div class="footer"></div>
		</form>
	</div>

	<div class="overlay"></div>

	<div class="loader">
		<div class="bounce1"></div>
		<div class="bounce2"></div>
		<div class="bounce3"></div>
	</div>

	<?php if (App::web()->user !== null) { ?>
		<div class="panel">
			<a href="#" class="close"></a>

			<form action="" method="post">
				<div class="header">
					<div class="back"></div>
					<div class="title"></div>
					<div class="description"></div>
				</div>
				<div class="container"></div>
				<div class="footer"></div>
			</form>
		</div>

		<div class="panel-item">
			<div class="label"></div>
			<a href="#" class="design"><span></span></a>
			<a href="#" class="settings"><span></span></a>
			<span class="item"></span>
		</div>
	<?php } ?>
</div>

<div id="errors">
	<?php foreach (Validator::getErrorMessages() as $key => $value) { ?>
		<div class="error <?php echo $key; ?>"><?php echo $value; ?></div>
	<?php } ?>
</div>

<div id="forms">
	<div class="form-container form-container-field">
		<label></label>
		<input type="text"/>
	</div>

	<div class="form-container form-container-password">
		<label></label>
		<input type="password"/>
	</div>

	<div class="form-container form-container-checkbox">
		<input type="checkbox"/>
		<label></label>
	</div>

	<button class="button"><span></span></button>
</div>

</body>
</html>