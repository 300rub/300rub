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
	<meta name="keywords" content="" />
	<meta name="description" content="" />

	<link href='//fonts.googleapis.com/css?family=Open+Sans:300,400,700,800&subset=latin,cyrillic-ext' rel='stylesheet' type='text/css'>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

	<link href='/css/css.css' rel='stylesheet' type='text/css'>
	<script src="/js/js.js"></script>
</head>
<body>

<div id="wrapper">
	<?php echo $content; ?>
</div>

<a
	href="#"
	id="login-button"
	data-action="<?php echo 123; ?>"
	data-title="<?php echo Language::t("common", "Вход"); ?>"
	data-button="<?php echo Language::t("common", "Войти"); ?>"
	></a>

<div id="ajax-wrapper"></div>

<div id="templates">
	<div class="window">
		<form action="" method="post">
			<a href="#" class="close">X</a>

			<div class="title"></div>
			<div class="container">

			</div>
			<div class="footer">
				<button></button>
			</div>
		</form>
	</div>

	<div class="overlay"></div>
</div>

</body>
</html>