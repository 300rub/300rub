<?php
use system\web\Language;
?>

<a href="#" class="j-panel-settings-duplicate"><?= Language::t("common", "Duplicate") ?></a>
<a
    href="#"
    class="j-panel-settings-delete"
    data-confirm="<?= Language::t("common", "Вы действительно хотите удалить раздел?") ?>"
><?= Language::t("common", "Delete") ?></a>

<button class="j-panel-settings-submit"><?= Language::t("common", "Save") ?></button>