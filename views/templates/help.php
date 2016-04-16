<?php
use components\Language;
?>
<div class="l-help j-help">
    <a href="#" class="l-close j-close"></a>

    <div class="l-header j-header j-hide"><?= Language::t("help", "help") ?></div>
    <div class="l-container j-container">
        <div class="j-loader j-hide">
            Loading
        </div>
        <div class="j-content"></div>
    </div>
</div>

<div class="l-help-overlay j-help-overlay"></div>