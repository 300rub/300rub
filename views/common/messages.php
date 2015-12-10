<?php
use system\base\Validator;
?>
<div id="errors">
	<?php foreach (Validator::getErrorMessages() as $key => $value) { ?>
		<div class="error <?php echo $key; ?>"><?php echo $value; ?></div>
	<?php } ?>
</div>