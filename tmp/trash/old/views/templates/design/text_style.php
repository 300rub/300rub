<?php
/**
 * @var \models\DesignTextModel $model
 */
?>
<?php
echo $model->size ? " font-size: {$model->size}px;" : "";
echo $model->color ? " color: {$model->color};" : "";
echo $model->isItalic ? " font-style: italic;" : "";
echo $model->isBold ? " font-weight: bold;" : "font-weight: normal;";
echo $model->align ? " text-align: " . $model->getTextAlign() . ";" : "";
echo $model->decoration ? " text-decoration: " . $model->getTextDecoration() . ";" : "";
echo $model->transform ? " text-transform: " . $model->getTextTransform() . ";" : "";
echo $model->letterSpacing ? " letter-spacing: {$model->letterSpacing}px;" : "";
echo ($model->lineHeight && $model->lineHeight != 100) ? " line-height: {$model->lineHeight}%;" : "";
?>
