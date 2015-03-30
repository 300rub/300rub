<?php

namespace system\web;

use system\App;
use system\base\Exception;
use system\base\Model;

/**
 * Файл класса Controller.
 *
 * Базовый абстрактный класс для работы с контроллерами
 *
 * @package system.web
 */
abstract class Controller
{

	/**
	 * Макет
	 *
	 * @var string
	 */
	protected $layout = "";

	/**
	 * Для передачи JSON
	 *
	 * @var array
	 */
	protected $json = array();

	/**
	 * Название директории для представлений
	 *
	 * @return string
	 */
	protected function getViewsDir() {
		return "common";
	}

	/**
	 * Показывает или возвращает представление в макете
	 *
	 * @param string $viewFile представление
	 * @param array  $data     данные
	 * @param bool   $isReturn возвращать ли результат
	 *
	 * @return string|void
	 */
	protected function render($viewFile, $data = array(), $isReturn = false)
	{
		$path = $this->getViewsRootDir() . "layouts/{$this->layout}.php";

		$content = $this->renderPartial($viewFile, $data, true);

		if (!$isReturn) {
			require($path);
		}

		ob_start();
		ob_implicit_flush(false);
		require($path);
		return ob_get_clean();
	}

	/**
	 * Показывает или возвращает представление
	 *
	 * @param string $viewFile представление
	 * @param array  $data     данные
	 * @param bool   $isReturn возвращать ли результат
	 *
	 * @return string|void
	 */
	protected function renderPartial($viewFile, $data = array(), $isReturn = false)
	{
		$path = $this->getViewsRootDir();
		if ($viewFile[0] !== "/") {
			$path .= $this->getViewsDir() . "/";
		} else {
			$viewFile = substr($viewFile, 1);
		}
		$path .= "{$viewFile}.php";

		extract($data, EXTR_OVERWRITE);

		if (!$isReturn) {
			require($path);
		}

		ob_start();
		ob_implicit_flush(false);
		require($path);
		return ob_get_clean();
	}

	/**
	 * Выводит на экран JSON
	 */
	protected function renderJson()
	{
		echo json_encode($this->json);
		exit();
	}

	/**
	 * Получает путь до директории представлений
	 *
	 * @return string
	 */
	protected function getViewsRootDir()
	{
		return App::web()->config->rootDir . "/views/";
	}

	/**
	 * Добавляет в JSON формы
	 *
	 * @param Model    $model
	 * @param string[] $fields
	 *
	 * @throws Exception
	 *
	 * @return Controller
	 */
	protected function setFormsForJson($model, $fields)
	{
		if (!$model) {
			throw new Exception("Не удалось получить модель");
		}

		if (!$fields) {
			throw new Exception("Не указаны формы");
		}

		$forms = array();

		foreach ($fields as $field) {
			$explode = explode(".", $field, 2);

			$m = null;
			if ($explode[0] === "t") {
				$m = $model;
			} else if (property_exists($model, $explode[0])) {
				$m = $model->$explode[0];
				if (!$m) {
					$className = $model->getRelationClass($explode[0]);
					$m = new $className;
				}
			}

			if ($m && property_exists($m, $explode[1])) {
				$forms[$field] = array(
					"rules" => $m->getRules($explode[1]),
					"label" => $m->getLabel($explode[1]),
					"type"  => $m->getFormType($explode[1]),
					"value" => $m->$explode[1],
				);
			}
		}

		if ($forms) {
			$this->json["forms"] = $forms;
		}


		return $this;
	}
}