<?php

namespace controllers;

use system\web\Controller;
use system\web\Language;

/**
 * Файл класса SectionController
 *
 * @package controllers
 */
class BlockController extends Controller
{

	public function actionPanelList()
	{
		$items = [];

		$items[] = [
			"label"   => Language::t("common", "Текст"),
			"content" => "text/panelList",
			"icon"    => "text"
		];

		$this->json = [
			"title"       => Language::t("common", "Блоки"),
			"description" => Language::t(
				"common",
				"Выберите категорию блоков"
			),
			"list"        => [
				"class"   => "panel",
				"items"   => $items,
				"icons"   => [
					"big"      => true,
					"design"   => false,
					"settings" => false,
				],
			],
			"errors"      => [],
		];

		$this->renderJson();
	}
}