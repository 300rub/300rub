<?php
/**
 * @var \models\DesignTextModel $model
 */
?>
<?php
echo $model->size ? " font-size: {$model->size}px;" : "";
echo $model->color ? " color: {$model->color};" : "";
echo $model->is_italic ? " font-style: italic;" : "";
echo $model->is_bold ? " font-weight: bold;" : "";
echo $model->align ? " text-align: " . $model->getTextAlign() . ";" : "";
echo $model->decoration ? " text-decoration: " . $model->getTextDecoration() . ";" : "";
echo $model->transform ? " text-transform: " . $model->getTextTransform() . ";" : "";
echo $model->letter_spacing ? " letter-spacing: {$model->letter_spacing}px;" : "";
echo ($model->line_height && $model->line_height != 100) ? " line-height: {$model->line_height}%;" : "";
?>
