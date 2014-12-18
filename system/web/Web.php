<?php

namespace system\web;

use system\base\Application;

/**
 * Файл класса Web.
 *
 * Web приложение
 *
 * @package system.web
 */
class Web extends Application
{

	/**
	 * Запускает команду
	 *
	 * @return void
	 */
	public function run()
	{
		$startTime = microtime(true);



		$time = number_format(microtime(true) - $startTime, 3);
		if ($this->config->isDebug) {
			echo "<script>console.log(\"Время выполнения скрипта: {$time} сек.\");</script>";
		}
	}
}