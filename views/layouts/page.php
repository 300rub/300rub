<?php
use system\base\Language;

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

	<link href='//fonts.googleapis.com/css?family=Open+Sans:300,400,700,800&subset=latin,cyrillic-ext' rel='stylesheet'
		  type='text/css'>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

	<link href='/css/css.css' rel='stylesheet' type='text/css'>

	<script src="/js/Window.js"></script>
	<script src="/js/Form.js"></script>
	<script src="/js/js.js"></script>

	<script>
		var LANG = "<?php echo Language::getActiveAlias(); ?>";
	</script>
</head>
<body>

<div id="wrapper">
	<?php echo $content; ?>
</div>

<a
	href="#"
	id="login-button"
	data-name="login"
	data-title="<?php echo Language::t("common", "Вход"); ?>"
	data-button="<?php echo Language::t("common", "Войти"); ?>"
	data-forms="user/form"
	data-send="user/login"
	></a>

<div id="ajax-wrapper"></div>

<div id="templates">
	<div class="window">
		<form action="" method="post">
			<div class="header">
				<a href="#" class="close"></a>

				<div class="title"></div>
			</div>
			<div class="container"></div>
			<div class="footer">
				<button></button>
			</div>
		</form>
	</div>

	<div class="overlay"></div>

	<div class="loader">
		<div class="bounce1"></div>
		<div class="bounce2"></div>
		<div class="bounce3"></div>
	</div>

	<div class="system-error">
		<?php echo Language::t(
			"common",
			"Случилось страшное, но мы уже знаем об этом. Проблема уже находится на стадии решения. Приносим свои извинения. Попробуйте данную операцию чуть позже."
		); ?>
	</div>
</div>

<div id="forms">
	<div class="field">
		<label></label>
		<input type="text"/>

		<div class="error"></div>
	</div>

	<div class="checkbox">
		<input type="checkbox"/>
		<label></label>
	</div>
</div>

</body>
</html>