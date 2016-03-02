<?php
use system\web\Language;
?>

<div class="j-panel-settings-section-container">
    <div>
        <label for="panel-settings-section-seoname-name"><?= Language::t("common", "Name") ?></label>
        <input id="panel-settings-section-seoname-name" class="j-seoModel__name j-validate" type="text"/>
    </div>
    <div>
        <label for="panel-settings-section-seoname-url"><?= Language::t("common", "URL") ?></label>
        <input id="panel-settings-section-seoname-url" class="j-seoModel__url j-validate" type="text"/>
    </div>
</div>