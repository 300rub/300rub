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
	 * Data from $_POST
	 *
	 * @var array
	 */
	public $data = [];

	protected $id = 0;

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
	protected $json = [];

	/**
	 * Показывает или возвращает представление в макете
	 *
	 * @param string $viewFile представление
	 * @param array  $data     данные
	 * @param bool   $isReturn возвращать ли результат
	 *
	 * @return string|void
	 */
	protected function render($viewFile, $data = [], $isReturn = false)
	{
		$path = $this->getViewsRootDir() . "{$this->layout}.php";

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
	protected function renderPartial($viewFile, $data = [], $isReturn = false)
	{
		$path = $this->getViewsRootDir() . $viewFile . ".php";

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

		$forms = [];

		foreach ($fields as $field) {
			$explode = explode(".", $field, 2);

			$m = null;
			if ($explode[0] === "t") {
				$m = $model;
			} else {
				if (property_exists($model, $explode[0])) {
					$m = $model->$explode[0];
					if (!$m) {
						$className = $model->getRelationClass($explode[0]);
						$m = new $className;
					}
				}
			}

			$field = $explode[1];
			if ($m && property_exists($m, $field)) {
				$type = $m->getFormType($field);
				$values = [];
				if ($type === "select") {
					$methodName = "get" . ucfirst($field) . "List";
					$values = $m->$methodName();
				}
				$forms[$explode[0] . "." . $field] = [
					"rules"  => $m->getRules($field),
					"label"  => $m->getLabel($field),
					"type"   => $type,
					"value"  => $m->$field,
					"values" => $values,
				];
			}
		}

		if ($forms) {
			$this->json["forms"] = $forms;
		}

		return $this;
	}
}