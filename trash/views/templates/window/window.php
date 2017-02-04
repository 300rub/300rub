<?php
use testS\components\Language;
?>
<div class="l-window j-window">
	<div class="l-window-container">
		<form class="j-window-form" method="post">
			<a class="l-close j-close fa fa-times"></a>
			<div class="l-header j-header d-hide"></div>
			<div class="l-container j-container">
				<i class="j-loader l-loader d-hide fa fa-circle-o-notch fa-spin fa-fw"></i>
			</div>
			<div class="l-footer j-footer d-hide">
				<a class="j-submit l-submit l-effect-fade" href="#">
					<span class="l-icons">
						<i class="j-icon fa"></i>
						<i class="j-loader d-hide fa fa-refresh fa-spin fa-fw"></i>
					</span>
					<span class="j-label"><?= Language::t("common", "save") ?></span>
				</a>
			</div>
		</form>
	</div>
</div>

<div class="l-overlay j-overlay"></div>