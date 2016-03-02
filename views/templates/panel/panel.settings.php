<?php
use system\web\Language;
?>

<a href="#" class="j-duplicate l-hide"><?= Language::t("common", "Duplicate") ?></a>
<a
    href="#"
    class="j-delete l-hide"
    data-confirm="<?= Language::t("common", "Вы действительно хотите удалить раздел?") ?>"
><?= Language::t("common", "Delete") ?></a>