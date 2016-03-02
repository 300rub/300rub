<?php
use system\web\Language;
?>
<div class="j-window-login-container">
	<div>
		<label for="window-login-login"><?= Language::t("common", "Login") ?></label>
		<input id="window-login-login" class="j-t__login j-validate" type="text"/>
	</div>
	<div>
		<label for="window-login-password"><?= Language::t("common", "Password") ?></label>
		<input id="window-login-password" class="j-t__password j-validate" type="password"/>
	</div>
</div>