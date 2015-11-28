<?php
use system\web\Language;
$uniqueId = uniqid();
?>
<div class="j-window-login-container">
	<div>
		<label for="<?= $uniqueId ?>-login"><?= Language::t("common", "Login") ?></label>
		<input id="<?= $uniqueId ?>-login" type="text" />
	</div>
	<div>
		<label for="<?= $uniqueId ?>-password"><?= Language::t("common", "Password") ?></label>
		<input id="<?= $uniqueId ?>-password" type="password" />
	</div>
</div>