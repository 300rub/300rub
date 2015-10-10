<?php
/**
 * @var \controllers\SectionController $this
 * @var \models\TextModel              $model
 */
?>

<div
	class="design-text-<?= $model->designTextModel->id ?> design-block-<?= $model->designTextModel->id ?>"
	style="<?php $this->renderPartial("/design/text", ["model" => $model->designTextModel]); ?>"
	><?= $model->text; ?></div>
