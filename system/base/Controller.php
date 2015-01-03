<?php

namespace system\base;
use system\App;

/**
 * Файл класса Controller.
 *
 * Базовый абстрактный класс для работы с контроллерами
 *
 * @package system.base
 */
abstract class Controller
{

	/**
	 * Макет
	 *
	 * @var string
	 */
	public $layout = "";

	/**
	 * Название директории для представлений
	 *
	 * @return string
	 */
	protected abstract function getViewsDir();

	/**
	 * Показывает или возвращает представление в макете
	 *
	 * @param string $viewFile представление
	 * @param array  $data     данные
	 * @param bool   $isReturn возвращать ли результат
	 *
	 * @return string|void
	 */
	public function render($viewFile, $data = array(), $isReturn = false)
	{
		$path = $this->getViewsRootDir() . "layouts/{$this->layout}.php";

		$content = $this->renderPartial($viewFile, $data, true);

		if (!$isReturn) {
			require($path);
			exit();
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
	public function renderPartial($viewFile, $data = array(), $isReturn = false)
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
	 * Получает путь до директории представлений
	 *
	 * @return string
	 */
	protected function getViewsRootDir()
	{
		return App::web()->config->rootDir . "views/";
	}
}