<?php
use system\base\Validator;
?>

<?php foreach (Validator::getErrorMessages() as $key => $value) { ?>
	<div class="j-error j-error-<?= $key ?>"><?= $value ?></div>
<?php } ?>