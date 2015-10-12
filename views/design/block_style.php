<?php
/**
 * @var \models\DesignBlockModel $model
 */
?>
<?php
if ($model->margin_top || $model->margin_right || $model->margin_bottom || $model->margin_left) {
	echo " margin: {$model->margin_top}px {$model->margin_right}px {$model->margin_bottom}px {$model->margin_left}px;";
}

if ($model->padding_top || $model->padding_right || $model->padding_bottom || $model->padding_left) {
	echo " padding: {$model->padding_top}px {$model->padding_right}px {$model->padding_bottom}px {$model->padding_left}px;";
}

if ($model->background_color && !$model->background) {
	echo " background-color: {$model->background_color};";
} elseif ($model->background && !$model->background_color) {
	echo " background-color: {$model->background};";
} elseif ($model->background_color && $model->background) {
	$gradientDirections = $model->getGradientDirections();
	echo "
	background: {$model->background_color};
	background: -moz-linear-gradient({$gradientDirections["mozLinear"]}, {$model->background_color} 0%, {$model->background} 100%);
	background: -webkit-gradient({$gradientDirections["webkit"]}, color-stop(0%, {$model->background_color}), color-stop(100%, {$model->background}));
	background: -webkit-linear-gradient({$gradientDirections["webkitLinear"]}, {$model->background_color} 0%, {$model->background} 100%);
	background: -o-linear-gradient({$gradientDirections["oLinear"]}, {$model->background_color} 0%, {$model->background} 100%);
	background: -ms-linear-gradient({$gradientDirections["msLinear"]}, {$model->background_color} 0%, {$model->background} 100%);
	background: linear-gradient({$gradientDirections["linear"]}, {$model->background_color} 0%, {$model->background} 100%);
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='{$model->background_color}', endColorstr='{$model->background}',GradientType={$gradientDirections["ie"]});
	";
}

$borderTop = "";
if ($model->border_top_width && $model->border_top_style && $model->border_top_color) {
	$borderTop = "{$model->border_top_width}px " . $model->getBorderStyleTop() . " $model->border_top_color";
}
$borderRight = "";
if ($model->border_right_width && $model->border_right_style && $model->border_right_color) {
	$borderRight = "{$model->border_right_width}px " . $model->getBorderStyleRight() . " $model->border_right_color";
}
$borderBottom = "";
if ($model->border_bottom_width && $model->border_bottom_style && $model->border_bottom_color) {
	$borderBottom = "{$model->border_bottom_width}px " . $model->getBorderStyleBottom() . " $model->border_bottom_color";
}
$borderLeft = "";
if ($model->border_left_width && $model->border_left_style && $model->border_left_color) {
	$borderLeft = "{$model->border_left_width}px " . $model->getBorderStyleLeft() . " $model->border_left_color";
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