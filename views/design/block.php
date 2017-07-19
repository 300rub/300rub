<?php
/**
 * @var \testS\models\DesignBlockModel $model
 * @var string                         $id
 * @var string                         $selector
 */
?><?= $selector ?>{<?php

$marginTop = $model->get("marginTop");
$marginRight = $model->get("marginRight");
$marginBottom = $model->get("marginBottom");
$marginLeft = $model->get("marginLeft");
//if ($marginTop !== 0 || $marginRight !== 0 || $marginBottom !== 0 || $marginLeft !== 0) {
    if ($marginTop > 0) {
        $marginTop .= "px";
    }
    if ($marginRight > 0) {
        $marginRight .= "px";
    }
    if ($marginBottom > 0) {
        $marginBottom .= "px";
    }
    if ($marginLeft > 0) {
        $marginLeft .= "px";
    }
?>margin:<?= $marginTop ?> <?= $marginRight ?> <?= $marginBottom ?> <?= $marginLeft ?>;<?php
//}



$paddingTop = $model->get("paddingTop");
$paddingRight = $model->get("paddingRight");
$paddingBottom = $model->get("paddingBottom");
$paddingLeft = $model->get("paddingLeft");
//if ($paddingTop !== 0 || $paddingRight !== 0 || $paddingBottom !== 0 || $paddingLeft !== 0) {
    if ($paddingTop > 0) {
        $paddingTop .= "px";
    }
    if ($paddingRight > 0) {
        $paddingRight .= "px";
    }
    if ($paddingBottom > 0) {
        $paddingBottom .= "px";
    }
    if ($paddingLeft > 0) {
        $paddingLeft .= "px";
    }
?>padding:<?= $paddingTop ?> <?= $paddingRight ?> <?= $paddingBottom ?> <?= $paddingLeft ?>;<?php
//}

?>}<?= $selector ?>:hover{<?php

//if ($model->get("hasMarginHover") === true) {
    $marginTop = $model->get("marginTopHover");
    $marginRight = $model->get("marginRightHover");
    $marginBottom = $model->get("marginBottomHover");
    $marginLeft = $model->get("marginLeftHover");
    //if ($marginTop !== 0 || $marginRight !== 0 || $marginBottom !== 0 || $marginLeft !== 0) {
        if ($marginTop > 0) {
            $marginTop .= "px";
        }
        if ($marginRight > 0) {
            $marginRight .= "px";
        }
        if ($marginBottom > 0) {
            $marginBottom .= "px";
        }
        if ($marginLeft > 0) {
            $marginLeft .= "px";
        }
?>margin:<?= $marginTop ?> <?= $marginRight ?> <?= $marginBottom ?> <?= $marginLeft ?>;<?php
    //}
//}

//if ($model->get("hasMarginHover") === true) {
    $paddingTop = $model->get("paddingTopHover");
    $paddingRight = $model->get("paddingRightHover");
    $paddingBottom = $model->get("paddingBottomHover");
    $paddingLeft = $model->get("paddingLeftHover");
    //if ($paddingTop !== 0 || $paddingRight !== 0 || $paddingBottom !== 0 || $paddingLeft !== 0) {
        if ($paddingTop > 0) {
            $paddingTop .= "px";
        }
        if ($paddingRight > 0) {
            $paddingRight .= "px";
        }
        if ($paddingBottom > 0) {
            $paddingBottom .= "px";
        }
        if ($paddingLeft > 0) {
            $paddingLeft .= "px";
        }
?>padding:<?= $paddingTop ?> <?= $paddingRight ?> <?= $paddingBottom ?> <?= $paddingLeft ?>;<?php
    //}
//}

?>}