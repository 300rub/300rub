<?php
/**
 * Variables
 *
 * @var bool   $isDisplayBlocks
 * @var bool   $isDisplaySections
 * @var bool   $isDisplaySettings
 * @var string $logoutYes
 * @var string $logoutNo
 * @var string $logoutConfirmText
 * @var string $releaseButton
 * @var string $sectionsButton
 * @var string $blocksButton
 * @var string $settingsButton
 * @var string $helpButton
 * @var string $logoutButton
 *
 * phpcs:disable Generic.Files.InlineHTML
 */
?>

<div id="user-buttons">
    <a>
        <span><?php echo $releaseButton; ?></span>
        <i class="fas fa-truck"></i>
    </a>
    <?php if ($isDisplayBlocks === true) { ?>
        <a id="user-button-block">
            <span><?php echo $blocksButton; ?></span>
            <i class="fas fa-th-large"></i>
        </a>
    <?php } ?>
    <?php if ($isDisplaySections === true) { ?>
        <a>
            <span><?php echo $sectionsButton; ?></span>
            <i class="far fa-file"></i>
        </a>
    <?php } ?>
    <a id="user-button-settings">
        <span><?php echo $settingsButton; ?></span>
        <i class="fas fa-wrench"></i>
    </a>
    <a>
        <span><?php echo $helpButton; ?></span>
        <i class="fas fa-question"></i>
    </a>
    <a id="user-button-logout">
        <span><?php echo $logoutButton; ?></span>
        <i class="fas fa-sign-out-alt"></i>
    </a>
    <div
        class="logout-confirmation hidden"
        data-yes="<?php echo $logoutYes; ?>"
        data-no="<?php echo $logoutNo; ?>"
    >
        <div><?php echo $logoutConfirmText; ?></div>
    </div>
</div>
