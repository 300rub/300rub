<?php

/**
 * @var \testS\models\DesignBlockModel $model
 * @var string                         $id
 * @var string                         $selector
 */

$css = "";

$marginTop = $model->get("marginTop");
$marginRight = $model->get("marginRight");
$marginBottom = $model->get("marginBottom");
$marginLeft = $model->get("marginLeft");
if ($marginTop !== 0
    || $marginRight !== 0
    || $marginBottom !== 0
    || $marginLeft !== 0
) {
    if ($marginTop !== 0) {
        $marginTop .= "px";
    }
    if ($marginRight !== 0) {
        $marginRight .= "px";
    }
    if ($marginBottom !== 0) {
        $marginBottom .= "px";
    }
    if ($marginLeft !== 0) {
        $marginLeft .= "px";
    }
    $css .= sprintf(
        "margin:%s %s %s %s;",
        $marginTop,
        $marginRight,
        $marginBottom,
        $marginLeft
    );
}

$paddingTop = $model->get("paddingTop");
$paddingRight = $model->get("paddingRight");
$paddingBottom = $model->get("paddingBottom");
$paddingLeft = $model->get("paddingLeft");
if ($paddingTop !== 0
    || $paddingRight !== 0
    || $paddingBottom !== 0
    || $paddingLeft !== 0
) {
    if ($paddingTop !== 0) {
        $paddingTop .= "px";
    }
    if ($paddingRight !== 0) {
        $paddingRight .= "px";
    }
    if ($paddingBottom !== 0) {
        $paddingBottom .= "px";
    }
    if ($paddingLeft !== 0) {
        $paddingLeft .= "px";
    }
    $css .= sprintf(
        "padding:%s %s %s %s;",
        $paddingTop,
        $paddingRight,
        $paddingBottom,
        $paddingLeft
    );
}

$backgroundColorFrom = $model->get("backgroundColorFrom");
$backgroundColorTo = $model->get("backgroundColorTo");
if ($model->get("hasBackgroundGradient") === false) {
    $backgroundColorTo = "";
}
if ($backgroundColorFrom !== ""
    && $backgroundColorTo === ""
) {
    $css .= sprintf("background-color:%s;", $backgroundColorFrom);
} elseif ($backgroundColorFrom === ""
    && $backgroundColorTo !== ""
) {
    $css .= sprintf("background-color:%s;", $backgroundColorTo);
} elseif ($backgroundColorFrom !== ""
    && $backgroundColorTo !== ""
) {
    $gradientDirection = $model->getGradientDirection();
    $css .= sprintf("background:%s;", $backgroundColorFrom);
    $css .= sprintf(
        "background:-moz-linear-gradient(%s, %s 0%%, %s 100%%);",
        $gradientDirection["mozLinear"],
        $backgroundColorFrom,
        $backgroundColorTo
    );
    $css .= sprintf(
        "background:-webkit-gradient(%s, color-stop(0%%, %s), color-stop(100%%, %s));",
        $gradientDirection["webkit"],
        $backgroundColorFrom,
        $backgroundColorTo
    );
    $css .= sprintf(
        "background:-webkit-linear-gradient(%s, %s 0%%, %s 100%%);",
        $gradientDirection["webkitLinear"],
        $backgroundColorFrom,
        $backgroundColorTo
    );
    $css .= sprintf(
        "background:-o-linear-gradient(%s, %s 0%%, %s 100%%);",
        $gradientDirection["oLinear"],
        $backgroundColorFrom,
        $backgroundColorTo
    );
    $css .= sprintf(
        "background:-ms-linear-gradient(%s, %s 0%%, %s 100%%);",
        $gradientDirection["msLinear"],
        $backgroundColorFrom,
        $backgroundColorTo
    );
    $css .= sprintf(
        "background:linear-gradient(%s, %s 0%%, %s 100%%);",
        $gradientDirection["linear"],
        $backgroundColorFrom,
        $backgroundColorTo
    );
    $css .= sprintf(
        "filter:progid:DXImageTransform.Microsoft.gradient( startColorstr='%s', endColorstr='%s',GradientType=%s);",
        $backgroundColorFrom,
        $backgroundColorTo,
        $gradientDirection["ie"]
    );
}

$borderTopLeftRadius = $model->get("borderTopLeftRadius");
$borderTopRightRadius = $model->get("borderTopRightRadius");
$borderBottomRightRadius = $model->get("borderBottomRightRadius");
$borderBottomLeftRadius = $model->get("borderBottomLeftRadius");
if ($borderTopLeftRadius !== 0
    || $borderTopRightRadius !== 0
    || $borderBottomRightRadius !== 0
    || $borderBottomLeftRadius !== 0
) {
    if ($borderTopLeftRadius !== 0) {
        $borderTopLeftRadius .= "px";
    }
    if ($borderTopRightRadius !== 0) {
        $borderTopRightRadius .= "px";
    }
    if ($borderBottomRightRadius !== 0) {
        $borderBottomRightRadius .= "px";
    }
    if ($borderBottomLeftRadius !== 0) {
        $borderBottomLeftRadius .= "px";
    }
    $css .= sprintf(
        "-webkit-border-radius:%s %s %s %s;",
        $borderTopLeftRadius,
        $borderTopRightRadius,
        $borderBottomRightRadius,
        $borderBottomLeftRadius
    );
    $css .= sprintf(
        "-moz-border-radius:%s %s %s %s;",
        $borderTopLeftRadius,
        $borderTopRightRadius,
        $borderBottomRightRadius,
        $borderBottomLeftRadius
    );
    $css .= sprintf(
        "border-radius:%s %s %s %s;",
        $borderTopLeftRadius,
        $borderTopRightRadius,
        $borderBottomRightRadius,
        $borderBottomLeftRadius
    );
}

$hasBorder = false;
$borderTopWidth = $model->get("borderTopWidth");
$borderRightWidth = $model->get("borderRightWidth");
$borderBottomWidth = $model->get("borderBottomWidth");
$borderLeftWidth = $model->get("borderLeftWidth");
if ($borderTopWidth !== 0
    || $borderRightWidth !== 0
    || $borderBottomWidth !== 0
    || $borderLeftWidth !== 0
) {
    $hasBorder = true;
    if ($borderTopWidth !== 0) {
        $borderTopWidth .= "px";
    }
    if ($borderRightWidth !== 0) {
        $borderRightWidth .= "px";
    }
    if ($borderBottomWidth !== 0) {
        $borderBottomWidth .= "px";
    }
    if ($borderLeftWidth !== 0) {
        $borderLeftWidth .= "px";
    }
    $css .= sprintf(
        "border-width:%s %s %s %s;",
        $borderTopWidth,
        $borderRightWidth,
        $borderBottomWidth,
        $borderLeftWidth
    );
}
if ($hasBorder === true) {
    $css .= sprintf(
        "border-style:%s;",
        $model->getBorderStyle()
    );
    $borderColor = $model->get("borderColor");
    if ($borderColor === "") {
        $borderColor = "transparent";
    }
    $css .= sprintf(
        "border-color:%s;",
        $borderColor
    );
}

$width = $model->get("width");
if ($width !== 0) {
    if ($width <= 100) {
        $width .= "%";
    } else {
        $width .= "px";
    }

    $css .= sprintf(
        "width:%s;",
        $width
    );
}

$transitions = [];
if ($model->get("hasMarginHover") === true
    && $model->get("hasMarginAnimation")
) {
    $transitions[] = "margin .3s";
}
if ($model->get("hasPaddingHover") === true
    && $model->get("hasPaddingAnimation")
) {
    $transitions[] = "padding .3s";
}
if ($model->get("hasBackgroundGradient") === false
    && $model->get("hasBackgroundHover") === true
    && $model->get("hasBackgroundAnimation")
) {
    $transitions[] = "background-color .3s";
}
if ($model->get("hasBorderHover") === true
    && $model->get("hasBorderAnimation")
) {
    $transitions[] = "border-radius .3s";
    $transitions[] = "border-width .3s";
    $transitions[] = "border-color .3s";
}
$transition = implode(",", $transitions);
if ($transition !== "") {
    $css .= sprintf("-webkit-transition:%s;", $transition);
    $css .= sprintf("-ms-transition:%s;", $transition);
    $css .= sprintf("-o-transition:%s;", $transition);
    $css .= sprintf("transition:%s;", $transition);
}

if ($css !== "") {
    echo sprintf("%s{%s}", $selector, $css);
}

$css = "";

if ($model->get("hasMarginHover") === true) {
    $marginTop = $model->get("marginTopHover");
    $marginRight = $model->get("marginRightHover");
    $marginBottom = $model->get("marginBottomHover");
    $marginLeft = $model->get("marginLeftHover");
    if ($marginTop !== 0
        || $marginRight !== 0
        || $marginBottom !== 0
        || $marginLeft !== 0
    ) {
        if ($marginTop !== 0) {
            $marginTop .= "px";
        }
        if ($marginRight !== 0) {
            $marginRight .= "px";
        }
        if ($marginBottom !== 0) {
            $marginBottom .= "px";
        }
        if ($marginLeft !== 0) {
            $marginLeft .= "px";
        }
        $css .= sprintf(
            "margin:%s %s %s %s;",
            $marginTop,
            $marginRight,
            $marginBottom,
            $marginLeft
        );
    }
}

if ($model->get("hasMarginHover") === true) {
    $paddingTop = $model->get("paddingTopHover");
    $paddingRight = $model->get("paddingRightHover");
    $paddingBottom = $model->get("paddingBottomHover");
    $paddingLeft = $model->get("paddingLeftHover");
    if ($paddingTop !== 0
        || $paddingRight !== 0
        || $paddingBottom !== 0
        || $paddingLeft !== 0
    ) {
        if ($paddingTop !== 0) {
            $paddingTop .= "px";
        }
        if ($paddingRight !== 0) {
            $paddingRight .= "px";
        }
        if ($paddingBottom !== 0) {
            $paddingBottom .= "px";
        }
        if ($paddingLeft !== 0) {
            $paddingLeft .= "px";
        }
        $css .= sprintf(
            "padding:%s %s %s %s;",
            $paddingTop,
            $paddingRight,
            $paddingBottom,
            $paddingLeft
        );
    }
}

if ($model->get("hasBackgroundHover") === true) {
    $backgroundColorFrom = $model->get("backgroundColorFromHover");
    $backgroundColorTo = $model->get("backgroundColorToHover");
    if ($model->get("hasBackgroundGradient") === false) {
        $backgroundColorTo = "";
    } else {
        if ($backgroundColorFrom !== "" && $backgroundColorTo === "") {
            $backgroundColorTo = $backgroundColorFrom;
        } elseif ($backgroundColorFrom === "" && $backgroundColorTo !== "") {
            $backgroundColorFrom = $backgroundColorTo;
        }
    }

    if ($backgroundColorFrom !== ""
        && $backgroundColorTo === ""
    ) {
        $css .= sprintf("background-color:%s;", $backgroundColorFrom);
    } elseif ($backgroundColorFrom === ""
        && $backgroundColorTo !== ""
    ) {
        $css .= sprintf("background-color:%s;", $backgroundColorTo);
    } elseif ($backgroundColorFrom !== ""
        && $backgroundColorTo !== ""
    ) {
        $gradientDirection = $model->getGradientDirection(true);
        $css .= sprintf("background:%s;", $backgroundColorFrom);
        $css .= sprintf(
            "background:-moz-linear-gradient(%s, %s 0%%, %s 100%%);",
            $gradientDirection["mozLinear"],
            $backgroundColorFrom,
            $backgroundColorTo
        );
        $css .= sprintf(
            "background:-webkit-gradient(%s, color-stop(0%%, %s), color-stop(100%%, %s));",
            $gradientDirection["webkit"],
            $backgroundColorFrom,
            $backgroundColorTo
        );
        $css .= sprintf(
            "background:-webkit-linear-gradient(%s, %s 0%%, %s 100%%);",
            $gradientDirection["webkitLinear"],
            $backgroundColorFrom,
            $backgroundColorTo
        );
        $css .= sprintf(
            "background:-o-linear-gradient(%s, %s 0%%, %s 100%%);",
            $gradientDirection["oLinear"],
            $backgroundColorFrom,
            $backgroundColorTo
        );
        $css .= sprintf(
            "background:-ms-linear-gradient(%s, %s 0%%, %s 100%%);",
            $gradientDirection["msLinear"],
            $backgroundColorFrom,
            $backgroundColorTo
        );
        $css .= sprintf(
            "background:linear-gradient(%s, %s 0%%, %s 100%%);",
            $gradientDirection["linear"],
            $backgroundColorFrom,
            $backgroundColorTo
        );
        $css .= sprintf(
            "filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='%s', endColorstr='%s',GradientType=%s);",
            $backgroundColorFrom,
            $backgroundColorTo,
            $gradientDirection["ie"]
        );
    }
}

if ($model->get("hasBorderHover") === true) {
    $borderTopLeftRadius = $model->get("borderTopLeftRadiusHover");
    $borderTopRightRadius = $model->get("borderTopRightRadiusHover");
    $borderBottomRightRadius = $model->get("borderBottomRightRadiusHover");
    $borderBottomLeftRadius = $model->get("borderBottomLeftRadiusHover");

    if ($borderTopLeftRadius !== 0) {
        $borderTopLeftRadius .= "px";
    }
    if ($borderTopRightRadius !== 0) {
        $borderTopRightRadius .= "px";
    }
    if ($borderBottomRightRadius !== 0) {
        $borderBottomRightRadius .= "px";
    }
    if ($borderBottomLeftRadius !== 0) {
        $borderBottomLeftRadius .= "px";
    }
    $css .= sprintf(
        "-webkit-border-radius:%s %s %s %s;",
        $borderTopLeftRadius,
        $borderTopRightRadius,
        $borderBottomRightRadius,
        $borderBottomLeftRadius
    );
    $css .= sprintf(
        "-moz-border-radius:%s %s %s %s;",
        $borderTopLeftRadius,
        $borderTopRightRadius,
        $borderBottomRightRadius,
        $borderBottomLeftRadius
    );
    $css .= sprintf(
        "border-radius:%s %s %s %s;",
        $borderTopLeftRadius,
        $borderTopRightRadius,
        $borderBottomRightRadius,
        $borderBottomLeftRadius
    );

    $borderTopWidth = $model->get("borderTopWidthHover");
    $borderRightWidth = $model->get("borderRightWidthHover");
    $borderBottomWidth = $model->get("borderBottomWidthHover");
    $borderLeftWidth = $model->get("borderLeftWidthHover");

    if ($borderTopWidth !== 0) {
        $borderTopWidth .= "px";
    }
    if ($borderRightWidth !== 0) {
        $borderRightWidth .= "px";
    }
    if ($borderBottomWidth !== 0) {
        $borderBottomWidth .= "px";
    }
    if ($borderLeftWidth !== 0) {
        $borderLeftWidth .= "px";
    }
    $css .= sprintf(
        "border-width:%s %s %s %s;",
        $borderTopWidth,
        $borderRightWidth,
        $borderBottomWidth,
        $borderLeftWidth
    );

    $css .= sprintf(
        "border-style:%s;",
        $model->getBorderStyle(true)
    );

    $borderColor = $model->get("borderColorHover");
    if ($borderColor === "") {
        $borderColor = "transparent";
    }
    $css .= sprintf(
        "border-color:%s;",
        $borderColor
    );
}

if ($css !== "") {
    echo sprintf("%s:hover{%s}", $selector, $css);
}