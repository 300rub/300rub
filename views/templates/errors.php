<?php
use components\Validator;
?>

<?php foreach (Validator::getErrorMessages() as $key => $value) { ?>
	<div class="j-error l-error j-error-<?= $key ?>">
		<i class="fa fa-exclamation"></i>
		<?= $value ?>
	</div>
<?php } ?>