<?php
use components\Language;
?>

<a class="j-panel-settings-duplicate">
    <span class="j-label"><?= Language::t("common", "duplicate") ?></span>
    <div class="j-loader j-hide">
        loading
    </div>
</a>
<a
    class="j-panel-settings-delete"
    data-confirm="<?= Language::t("section", "deleteConfirmation") ?>"
>
    <span class="j-label"><?= Language::t("common", "delete") ?></span>
    <div class="j-loader j-hide">
        loading
    </div>
</a>