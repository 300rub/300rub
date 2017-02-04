<?php
/**
 * @var \models\DesignBlockModel $model
 */
?>
<?php
if ($model->marginTop || $model->marginRight || $model->marginBottom || $model->marginLeft) {
	echo " margin: {$model->marginTop}px {$model->marginRight}px {$model->marginBottom}px {$model->marginLeft}px;";
}

if ($model->paddingTop || $model->paddingRight || $model->paddingBottom || $model->paddingLeft) {
	echo " padding: {$model->paddingTop}px {$model->paddingRight}px {$model->paddingBottom}px {$model->paddingLeft}px;";
}

if ($model->backgroundColorFrom && !$model->backgroundColorTo) {
	echo " background-color: {$model->backgroundColorFrom};";
} elseif ($model->backgroundColorTo && !$model->backgroundColorFrom) {
	echo " background-color: {$model->backgroundColorTo};";
} elseif ($model->backgroundColorFrom && $model->backgroundColorTo) {
	$gradientDirection = $model->getGradientDirection();
	echo "
	background: {$model->backgroundColorFrom};
	background: -moz-linear-gradient({$gradientDirection["mozLinear"]}, {$model->backgroundColorFrom} 0%, {$model->backgroundColorTo} 100%);
	background: -webkit-gradient({$gradientDirection["webkit"]}, color-stop(0%, {$model->backgroundColorFrom}), color-stop(100%, {$model->backgroundColorTo}));
	background: -webkit-linear-gradient({$gradientDirection["webkitLinear"]}, {$model->backgroundColorFrom} 0%, {$model->backgroundColorTo} 100%);
	background: -o-linear-gradient({$gradientDirection["oLinear"]}, {$model->backgroundColorFrom} 0%, {$model->backgroundColorTo} 100%);
	background: -ms-linear-gradient({$gradientDirection["msLinear"]}, {$model->backgroundColorFrom} 0%, {$model->backgroundColorTo} 100%);
	background: linear-gradient({$gradientDirection["linear"]}, {$model->backgroundColorFrom} 0%, {$model->backgroundColorTo} 100%);
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='{$model->backgroundColorFrom}', endColorstr='{$model->backgroundColorTo}',GradientType={$gradientDirection["ie"]});
	";
}

$borderTop = "";
if ($model->borderTopWidth && $model->borderStyle) {
	$borderTop = "{$model->borderTopWidth}px " . $model->getBorderStyle() . " $model->borderColor";
}
$borderRight = "";
if ($model->borderRightWidth && $model->borderStyle) {
	$borderRight = "{$model->borderRightWidth}px " . $model->getBorderStyle() . " $model->borderColor";
}
$borderBottom = "";
if ($model->borderBottomWidth && $model->borderStyle) {
	$borderBottom = "{$model->borderBottomWidth}px " . $model->getBorderStyle() . " $model->borderColor";
}
$borderLeft = "";
if ($model->borderLeftWidth && $model->borderStyle) {
	$borderLeft = "{$model->borderLeftWidth}px " . $model->getBorderStyle() . " $model->borderColor";
}
if ($borderTop && $borderTop === $borderRight && $borderTop === $borderBottom && $borderTop === $borderLeft) {
	echo " border: {$borderTop};";
} else {
	if ($borderTop) {
		echo " border-top: {$borderTop};";
	}
	if ($borderRight) {
		echo " border-right: {$borderRight};";
	}
	if ($borderBottom) {
		echo " border-bottom: {$borderBottom};";
	}
	if ($borderLeft) {
		echo " border-left: {$borderLeft};";
	}
}

if (
	$model->borderTopLeftRadius
	&& $model->borderTopLeftRadius == $model->borderTopRightRadius
	&& $model->borderTopLeftRadius == $model->borderBottomRightRadius
	&& $model->borderTopLeftRadius == $model->borderBottomLeftRadius
) {
	echo "
	-webkit-border-radius: {$model->borderTopLeftRadius}px;
	-moz-border-radius: {$model->borderTopLeftRadius}px;
	border-radius: {$model->borderTopLeftRadius}px;
	";
} else {
	if ($model->borderTopLeftRadius) {
		echo "
			-webkit-border-top-left-radius: {$model->borderTopLeftRadius}px;
			-moz-border-radius-topleft: {$model->borderTopLeftRadius}px;
			border-top-left-radius: {$model->borderTopLeftRadius}px;
		";
	}
	if ($model->borderTopRightRadius) {
		echo "
			-webkit-border-top-right-radius: {$model->borderTopRightRadius}px;
			-moz-border-radius-topright: {$model->borderTopRightRadius}px;
			border-top-right-radius: {$model->borderTopRightRadius}px;
		";
	}
	if ($model->borderBottomRightRadius) {
		echo "
			-webkit-border-bottom-right-radius: {$model->borderBottomRightRadius}px;
			-moz-border-radius-bottomright: {$model->borderBottomRightRadius}px;
			border-bottom-right-radius: {$model->borderBottomRightRadius}px;
		";
	}
	if ($model->borderBottomLeftRadius) {
		echo "
			-webkit-border-bottom-left-radius: {$model->borderBottomLeftRadius}px;
			-moz-border-radius-bottomleft: {$model->borderBottomLeftRadius}px;
			border-bottom-left-radius: {$model->borderBottomLeftRadius}px;
		";
	}
}
?>