<?php
/**
 * @var \models\DesignBlockModel $model
 */
?>
<?php
if ($model->marginTop || $model->marginRight || $model->margin_bottom || $model->margin_left) {
	echo " margin: {$model->marginTop}px {$model->marginRight}px {$model->margin_bottom}px {$model->margin_left}px;";
}

if ($model->padding_top || $model->padding_right || $model->padding_bottom || $model->padding_left) {
	echo " padding: {$model->padding_top}px {$model->padding_right}px {$model->padding_bottom}px {$model->padding_left}px;";
}

if ($model->background_color_from && !$model->background_color_to) {
	echo " background-color: {$model->background_color_from};";
} elseif ($model->background_color_to && !$model->background_color_from) {
	echo " background-color: {$model->background_color_to};";
} elseif ($model->background_color_from && $model->background_color_to) {
	$gradientDirection = $model->getGradientDirection();
	echo "
	background: {$model->background_color_from};
	background: -moz-linear-gradient({$gradientDirection["mozLinear"]}, {$model->background_color_from} 0%, {$model->background_color_to} 100%);
	background: -webkit-gradient({$gradientDirection["webkit"]}, color-stop(0%, {$model->background_color_from}), color-stop(100%, {$model->background_color_to}));
	background: -webkit-linear-gradient({$gradientDirection["webkitLinear"]}, {$model->background_color_from} 0%, {$model->background_color_to} 100%);
	background: -o-linear-gradient({$gradientDirection["oLinear"]}, {$model->background_color_from} 0%, {$model->background_color_to} 100%);
	background: -ms-linear-gradient({$gradientDirection["msLinear"]}, {$model->background_color_from} 0%, {$model->background_color_to} 100%);
	background: linear-gradient({$gradientDirection["linear"]}, {$model->background_color_from} 0%, {$model->background_color_to} 100%);
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='{$model->background_color_from}', endColorstr='{$model->background_color_to}',GradientType={$gradientDirection["ie"]});
	";
}

$borderTop = "";
if ($model->border_top_width && $model->border_style) {
	$borderTop = "{$model->border_top_width}px " . $model->getBorderStyle() . " $model->border_color";
}
$borderRight = "";
if ($model->border_right_width && $model->border_style) {
	$borderRight = "{$model->border_right_width}px " . $model->getBorderStyle() . " $model->border_color";
}
$borderBottom = "";
if ($model->border_bottom_width && $model->border_style) {
	$borderBottom = "{$model->border_bottom_width}px " . $model->getBorderStyle() . " $model->border_color";
}
$borderLeft = "";
if ($model->border_left_width && $model->border_style) {
	$borderLeft = "{$model->border_left_width}px " . $model->getBorderStyle() . " $model->border_color";
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
	$model->border_top_left_radius
	&& $model->border_top_left_radius == $model->border_top_right_radius
	&& $model->border_top_left_radius == $model->border_bottom_right_radius
	&& $model->border_top_left_radius == $model->border_bottom_left_radius
) {
	echo "
	-webkit-border-radius: {$model->border_top_left_radius}px;
	-moz-border-radius: {$model->border_top_left_radius}px;
	border-radius: {$model->border_top_left_radius}px;
	";
} else {
	if ($model->border_top_left_radius) {
		echo "
			-webkit-border-top-left-radius: {$model->border_top_left_radius}px;
			-moz-border-radius-topleft: {$model->border_top_left_radius}px;
			border-top-left-radius: {$model->border_top_left_radius}px;
		";
	}
	if ($model->border_top_right_radius) {
		echo "
			-webkit-border-top-right-radius: {$model->border_top_right_radius}px;
			-moz-border-radius-topright: {$model->border_top_right_radius}px;
			border-top-right-radius: {$model->border_top_right_radius}px;
		";
	}
	if ($model->border_bottom_right_radius) {
		echo "
			-webkit-border-bottom-right-radius: {$model->border_bottom_right_radius}px;
			-moz-border-radius-bottomright: {$model->border_bottom_right_radius}px;
			border-bottom-right-radius: {$model->border_bottom_right_radius}px;
		";
	}
	if ($model->border_bottom_left_radius) {
		echo "
			-webkit-border-bottom-left-radius: {$model->border_bottom_left_radius}px;
			-moz-border-radius-bottomleft: {$model->border_bottom_left_radius}px;
			border-bottom-left-radius: {$model->border_bottom_left_radius}px;
		";
	}
}
?>