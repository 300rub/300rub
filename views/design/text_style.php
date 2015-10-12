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
echo $model->getTextAlign() ? " text-align: " . $model->getTextAlign() . ";" : "";
echo $model->getTextDecoration() ? " text-decoration: " . $model->getTextDecoration() . ";" : "";
echo $model->getTextTransform() ? " text-transform: " . $model->getTextTransform() . ";" : "";
echo $model->letter_spacing ? " letter-spacing: {$model->letter_spacing}px;" : "";
echo $model->line_height ? " line-height: {$model->line_height}%" : "";
?>
