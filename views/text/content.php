<?php
/**
 * @var \controllers\SectionController $this
 * @var \models\TextModel              $model
 */
?>

<div
	class="design-text-<?= $model->designTextModel->id ?> design-block-<?= $model->designTextModel->id
	?><?= $model->designTextModel->getFontFamilyClass() ? " " . $model->designTextModel->getFontFamilyClass() : "" ?>"
	style="<?php
	$this->renderPartial("/design/text_style", ["model" => $model->designTextModel]);
	$this->renderPartial("/design/block_style", ["model" => $model->designBlockModel]);
	?>"
	><?= $model->text; ?></div>
