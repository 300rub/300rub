<?php
use system\web\Language;
?>
<div class="j-window-login-container">
	<div>
		<label><?= Language::t("user", "login") ?>
			<input class="j-t__login j-validate" type="text"/>
		</label>
	</div>
	<div>
		<label><?= Language::t("user", "password") ?>
			<input class="j-t__password j-validate" type="password"/>
		</label>
	</div>
</div>