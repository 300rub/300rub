<?php

use ss\application\App;

$language = App::getInstance()->getLanguage();

//phpcs:disable Generic.Files.InlineHTML
?>

<div class="window loading transparent">
    <div class="header">
        <div class="title"></div>
        <a class="close gray-red-link fas fa-times"></a>
    </div>

    <div class="body scroll-container"></div>

    <div class="footer"></div>

    <i class="fas fas fa-circle-notch fa-spin loader"></i>
</div>

<div class="window-overlay transparent"></div>

<div class="window-confirm-unsaved">
    <div class="confirm-container">
        <div class="text">
            <?php echo $language->getMessage('form', 'unsavedWindow'); ?>
        </div>
        <div
            class="buttons"
            data-close="<?php echo $language->getMessage('form', 'unsavedWindowClose'); ?>"
            data-stay="<?php echo $language->getMessage('form', 'unsavedWindowStay'); ?>"
        ></div>
    </div>
</div>
