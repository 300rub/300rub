<?php
use system\web\Language;
?>

<div class="j-window-section-container"></div>

<div class="j-window-section-line l-window-section-line l-hide">
    <div class="j-header l-header">
        <div class="j-title l-title">
            <label><?= Language::t("common", "Линия"); ?> <span></span>
                <select class="j-select-block">
                    <option value="0" data-id="0" data-type="0">
                        <?php echo Language::t("common", "добавить блок"); ?>
                    </option>
                </select>
            </label>
        </div>
        <a href="#" class="j-remove l-remove"><?= Language::t("common", "Удалить"); ?></a>
    </div>
    <div class="j-grid-stack l-grid-stack"></div>
</div>

<button class="j-window-section-add-line l-hide"><?= Language::t("common", "Add line"); ?></button>

<div class="j-window-section-grid-stack-item l-grid-stack-item">
    <a href="#" class="j-remove l-remove">x</a>
    <div class="j-content"></div>
</div>