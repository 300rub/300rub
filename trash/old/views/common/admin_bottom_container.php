<?php 
use testS\components\Language;
?>
<div id="admin-bottom-container">
    <div class="l-left">
        <a id="logout-button" class="j-admin-bottom-button j-logout-button l-button">
            <i class="l-icon fa fa-sign-out"></i>
            <span><?= Language::t("user", "logout") ?></span>
        </a>
        <?php
        /*
        ?>
        <a class="j-admin-bottom-button l-button">
            <i class="l-icon fa fa-info"></i>
            <span><?= Language::t("common", "about") ?></span>
        </a>
        <a class="j-admin-bottom-button l-button">
            <i class="l-icon fa fa-question"></i>
            <span><?= Language::t("common", "help") ?></span>
        </a>
        */
        ?>
    </div>

    <div class="l-right">
        <?php
        /*
        ?>
        <a
            data-action="payment.panel"
            data-container="l-panel-payment"
            class="j-admin-bottom-button j-panel-open l-button"
        >
            <i class="l-icon fa fa-rub"></i>
            <span><?= Language::t("payment", "payment") ?></span>
        </a>

        <a
            data-action="payment.panel"
            data-container="l-panel-settings"
            class="j-admin-bottom-button j-panel-open l-button"
        >
            <i class="l-icon fa fa-cog"></i>
            <span><?= Language::t("settings", "settings") ?></span>
        </a>
        */
        ?>

        <a
            data-action="section.panelList"
            data-container="l-panel-sections"
            class="j-admin-bottom-button j-panel-open l-button"
        >
            <i class="l-icon fa fa-clone"></i>
            <span><?= Language::t("section", "sections") ?></span>
        </a>

        <a
            data-action="block.panelList"
            data-container="l-panel-blocks"
            class="j-admin-bottom-button j-panel-open l-button"
        >
            <i class="l-icon fa fa-th-large"></i>
            <span><?= Language::t("block", "blocks") ?></span>
        </a>
    </div>
</div>