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
	 * @var integer
	 */
	public $statusCode = 0;

	/**
	 * Конструктор
	 *
	 * @param string  $message сообщение
	 * @param integer $status  статус
	 * @param integer $code    код
	 */
	public function __construct($message, $status = 500, $code = 0)
	{
		$this->statusCode = $status;
		parent::__construct($message, $code);
	}
}