<?php
/**
 * Database
 * 
 * Абстрактный класс для работы с базами данных
 * 
 * Абстрактные методы:
 * 1) exec     - выполняет запрос без обработки результата
 * 2) fetchAll - возвращает все записи по запросу
 * 3) fetchRow - возвращает одну строку
 * 4) fetchCol - возвращает столбец
 * 5) fetchOne - возвращает скалярное значение
 * 
 * @author Pavel Vyazovoi <vyazovoi@googlemail.com>
 * @version 0.1
 * @package Core
 */
abstract class Database {
	
	public $db_host;
	public $db_name;
	public $db_login;
	public $db_password;
	
	/**
	 * Дескриптор подключения к БД
	 */
	protected $descriptor;
	
	abstract function fetchAll($query);
	abstract function fetchRow($query);
	abstract function fetchCol($query);
	abstract function fetchOne($query);
	
}
?>