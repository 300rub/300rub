<?php
use system\web\Language;
?>

<a href="#" class="j-panel-settings-duplicate"><?= Language::t("common", "duplicate") ?></a>
<a
    href="#"
    class="j-panel-settings-delete"
    data-confirm="<?= Language::t("section", "deleteConfirmation") ?>"
><?= Language::t("common", "delete") ?></a>

<button class="j-panel-settings-submit"><?= Language::t("common", "save") ?></button>