<?php
use components\Language;
?>
<div class="l-window j-window">
	<div class="l-window-container">
		<form class="j-window-form" method="post">
			<a class="l-close j-close fa fa-times"></a>
	
			<div class="l-header j-header j-hide"></div>
			<div class="l-container j-container">
				<div class="j-loader l-loader j-hide">
					<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
				</div>
			</div>
			<div class="l-footer j-footer j-hide">
				<a class="j-submit l-submit l-effect-fade" href="#">
					<span class="j-label"><?= Language::t("common", "save") ?></span>
					<span class="l-icons">
						<i class="j-icon fa"></i>
						<i class="j-loader j-hide fa fa-refresh fa-spin fa-fw"></i>
					</span>
				</a>
			</div>
		</form>
	</div>
</div>

<div class="l-overlay j-overlay"></div>