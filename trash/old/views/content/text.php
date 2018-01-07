<?php
/**
 * @var \controllers\SectionController $this
 * @var \models\TextModel              $model
 */
?>

<<?= $model->getTag() ?>
    class="design-text-<?= $model->designTextModel->id ?> design-block-<?= $model->designBlockModel->id
?><?= ($model->designTextModel->getFontFamilyClass() && !$model->isEditor) ? " " .
    $model->designTextModel->getFontFamilyClass() : "" ?>"
 style="<?php
if (!$model->isEditor) {
    $this->renderPartial("/templates/design/text_style", ["model" => $model->designTextModel]);
}
    $this->renderPartial("/templates/design/block_style", ["model" => $model->designBlockModel]);
?>"
><?= $model->text; ?></<?= $model->getTag() ?>>