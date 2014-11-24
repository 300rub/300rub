<?php

namespace system\base;

use Exception as E;

/**
 * Файл класса Exception
 *
 * @package system.base
 */
class Exception extends E
{

	/**
	 * Статус ошибки
	 *
	 * @var int
	 */
	public $statusCode = 0;

	/**
	 * Конструктор
	 *
	 * @param string $message сообщение
	 * @param int    $status  статус
	 * @param int    $code    код
	 */
	public function __construct($message, $status = 500, $code = 0)
	{
		$this->statusCode = $status;
		parent::__construct($message, $code);
	}
}