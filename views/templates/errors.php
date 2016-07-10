<?php
use components\Validator;
use components\Language;
?>

<?php foreach (Validator::getErrorMessages() as $key => $value) { ?>
	<div class="j-error l-error j-error-<?= $key ?>">
		<i class="fa fa-exclamation"></i>
		<?= $value ?>
	</div>
<?php } ?>
<div class="j-system-error l-system-error"><?= Language::t("common", "error") ?></div>
