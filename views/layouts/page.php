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

	<link href='/css/fonts/myriad-pro.css' rel='stylesheet' type='text/css'>
	<link href='/css/css.css' rel='stylesheet' type='text/css'>
	<?php if (App::web()->user !== null) { ?>
		<link href='/css/admin.css' rel='stylesheet' type='text/css'>
	<?php } ?>

	<script src="/js/Window.js"></script>
	<script src="/js/Form.js"></script>
	<script src="/js/Validator.js"></script>
	<script src="/js/js.js"></script>

	<?php if (App::web()->user !== null) { ?>
		<script src="/js/Panel.js"></script>
		<script src="/js/admin.js"></script>
	<?php } ?>

	<script>
		var LANG = "<?php echo Language::getActiveAlias(); ?>";
	</script>
</head>
<body>

<div id="wrapper">
	<?php echo $content; ?>
</div>

<?php if (App::web()->user === null) { ?>
	<a
		href="#"
		id="login-button"
		data-name="login"
		data-title="<?php echo Language::t("common", "Вход"); ?>"
		data-button="<?php echo Language::t("common", "Войти"); ?>"
		data-forms="user/form"
		data-send="user/login"
		>Вход</a>
<?php } else { ?>
	<a
		href="#"
		id="sections-button"
		data-name="sections"
		data-title="<?php echo Language::t("common", "Разделы"); ?>"
		>Разделы</a>

	<a href="#" id="logout-button"></a>
<?php } ?>

<div id="ajax-wrapper"></div>

<div id="templates">
	<div class="window">
		<form action="" method="post">
			<a href="#" class="close"></a>
			<div class="header"></div>
			<div class="container"></div>
			<div class="footer">
				<button>
					<span></span>
				</button>
			</div>
		</form>
	</div>

	<div class="overlay"></div>

	<div class="loader">
		<div class="bounce1"></div>
		<div class="bounce2"></div>
		<div class="bounce3"></div>
	</div>

	<div class="panel">
		<form action="" method="post">
			<div class="header">
				<a href="#" class="close"></a>

				<div class="title"></div>
			</div>
			<div class="container"></div>
		</form>
	</div>
</div>

<div id="errors">
	<?php foreach (Validator::getErrorMessages() as $key => $value) { ?>
		<div class="error <?php echo $key; ?>"><?php echo $value; ?></div>
	<?php } ?>
</div>

<div id="forms">
	<div class="form-container form-container-field">
		<label></label>
		<input type="text" />
	</div>

	<div class="form-container form-container-password">
		<label></label>
		<input type="password" />
	</div>

	<div class="form-container form-container-checkbox">
		<input type="checkbox" />
		<label></label>
	</div>
</div>

</body>
</html>