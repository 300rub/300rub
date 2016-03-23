<?php
use system\web\Language;
?>

<a href="#" class="j-panel-settings-duplicate">
    <span class="j-label"><?= Language::t("common", "duplicate") ?></span>
    <div class="j-loader j-hide">
        loading
    </div>
</a>
<a
    href="#"
    class="j-panel-settings-delete"
    data-confirm="<?= Language::t("section", "deleteConfirmation") ?>"
>
    <span class="j-label"><?= Language::t("common", "delete") ?></span>
    <div class="j-loader j-hide">
        loading
    </div>
</a>

<button class="j-panel-settings-submit">
    <span class="j-label"><?= Language::t("common", "save") ?></span>
    <div class="j-loader j-hide">
        loading
    </div>
</button>