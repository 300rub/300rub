<?php
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

	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,700,800&subset=latin,cyrillic-ext' rel='stylesheet' type='text/css'>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
</head>
<body>

<?php echo $content; ?>

<a href="#" id="login-button" data-title="Вход">Вход</a>

<div id="templates">
	<div id="window-template">
		<div class="window window-{NAME}">
			<form action="{ACTION}" method="post">
				<a href="#" class="close">X</a>

				<div class="title">{TITLE}</div>
				<div class="container">
					{CONTENT}
				</div>
				<div class="footer">
					<button>234</button>
				</div>
			</form>
		</div>

		<div class="overlay overlay-{NAME}"></div>
	</div>
</div>

</body>
</html>