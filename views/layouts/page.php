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

	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,800,300,700&subset=latin,cyrillic-ext' rel='stylesheet' type='text/css'>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>



</head>
<body>

<?php echo $content; ?>

<a id="login-button" data-title="Вход"></a>

<div id="ajax-templates">
	<div id="window-template">
		<div class="window window-{TYPE} window-level-{LEVEL}">
			<div class="close"></div>
			<div class="title">{TITLE}</div>
			<div class="scroll-container">
				<div class="content">
					{CONTENT}
				</div>
			</div>
			<div class="footer">
				<div class="container">
					{FOOTER}
				</div>
			</div>
		</div>
		<div class="overlay overlay-{TYPE} overlay-level-{LEVEL}" data-type="{TYPE}"></div>
	</div>

	<div id="panel-template">
		<div id="panel">
			<div class="container container-{TYPE}">
				<i class="close"></i>
				<div class="title">{TITLE}</div>
				<div class="description">{DESCRIPTION}</div>
				<div class="scroll-container">
					{CONTENT}
				</div>
			</div>
		</div>
	</div>

	<div id="subpanel-template">
		<div id="subpanel">
			<i class="close"></i>
			<div class="title">{TITLE}</div>
			<div class="scroll-container">
				{CONTENT}
			</div>
		</div>
	</div>
</div>

<div id="ajax-wrapper"></div>

</body>
</html>