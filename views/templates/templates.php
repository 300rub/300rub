<?php
/**
 * Variables
 *
 * @var bool $isUser
 *
 * phpcs:disable Generic.Files.InlineHTML
 */
?>

<div id="templates">
<?php
require 'common.php';
if ($isUser === true) {
    include 'admin.php';
}
?>
</div>
