<?php
/**
 * @var \models\TextModel $model
 */

$dt = $model->designTextModel;
?>

<div style="<?= $dt->size ? " font-size: {$dt->size}px;" : "" ?>"><?= $model->text; ?></div>
