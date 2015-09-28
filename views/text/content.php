<?php
/**
 * @var \controllers\SectionController $this
 * @var \models\TextModel              $model
 */
?>

<div style="<?php $this->renderPartial("/design/text", ["model" => $model->designTextModel]); ?>"><?= $model->text; ?></div>
