<?php
use components\Language;
?>

<div class="j-window-section-container"></div>

<div class="j-window-section-line l-window-section-line j-hide">
    <div class="j-header l-header">
        <div class="j-title l-title">
            <label><?= Language::t("section", "line"); ?> <span></span>
                <select class="j-select-block">
                    <option value="0" data-id="0" data-type="0">
                        <?php echo Language::t("section", "addBlock"); ?>
                    </option>
                </select>
            </label>
        </div>
        <a href="#" class="j-remove l-remove"><?= Language::t("common", "delete"); ?></a>
    </div>
    <div class="j-grid-stack l-grid-stack"></div>
</div>

<button class="j-window-section-add-line j-hide"><?= Language::t("section", "addLine"); ?></button>

<div class="j-window-section-grid-stack-item l-grid-stack-item">
    <a href="#" class="j-remove l-remove">x</a>
    <div class="j-content"></div>
</div>