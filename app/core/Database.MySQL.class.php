<?php
/**
 * MySQL
 *
 * Класс реализует работу с БД MySQL
 * Дополнительно описание см. Database
 *
 * Собственные методы:
 * 1) escape - экранирует переданный параметр
 * 2) insert_id - mysql_insert_id
 * 3) insert_id_sql - см. выше только через SQL-запрос
 *
 * @version 0.1
 * @package Core
 */
class MySQL extends Database {

   	public $dbHost;
	public $dbName;
	public $dbUser;
	public $dbPassword;

    /**
     * Подключение к базе данных
     */
    function connect() {
        $this->descriptor=mysql_pconnect($this->dbHost,$this->dbUser,$this->dbPassword) or die(mysql_error()); // FIXME: заменить or die на вменяемый обработчик экзепшенов
        mysql_select_db($this->dbName,$this->descriptor);
        $this->exec("SET NAMES 'UTF8'");
        return True;
    }

    /**
     * Exec
     *
     * Функция выполняет запрос без обработки результата
     *
     * @param string $query SQL-запрос
     */
    function exec($query) {
        //echo $query;
        mysql_query($query,$this->descriptor);
    }

    /**
     * Escape
     *
     * Функция корректно экранирует текст
     *
     * @param string $string Строка, которую необходимо экранировать
     * @return string Экранированная строка
     */
    function escape($string) {
        return mysql_real_escape_string(htmlspecialchars($string), $this->descriptor);
    }

    /**
     * fetchAll
     *
     * Возвращает весь рекордсет в виде ассоциативного массива,
     * ключом которого является порядковый номер элемента,
     * а элементом - вложенный ассоциативный массив с данными
     *
     * @param string $query SQL-запрос
     * @return array массив с результатом запроса
     */
    function fetchAll($query) {
        //echo $query;
        $result=array();
		//счетчик
		$num=1;
        $row_set=mysql_query($query,$this->descriptor);
        while($line=mysql_fetch_assoc($row_set))
		{
			$result[$num]=$line;
			$num++;
		}
        return $result;
    }

    /**
     * fetchRow
     *
     * Возвращает строку
     *
     * @param string $query SQL-запрос
     * @return array ассоциативный массив с результатом запроса
     */
    function fetchRow($query) {
        $result=mysql_query($query,$this->descriptor);
        return mysql_fetch_assoc($result);
    }

    /**
     * fetchCol
     *
     * Возвращает столбец
     *
     * @param string $query SQL-запрос
     * @return array массив с результатом запроса
     * TODO: реализовать
     */
    function fetchCol($query) {
        $result=mysql_query($query,$this->descriptor);
        $resultCol = array();
        while ($line = mysql_fetch_array($result)) {
            $resultCol[] = $line[0];
        }

        return $resultCol;
    }

    /**
     * fetchOne
     *
     * Возвращает скалярное значение
     *
     * @param string $query SQL-запрос
     * @return string результат запроса
     * TODO: реализовать
     */
    function fetchOne($query) {
        //echo $query;
        $result=mysql_query($query,$this->descriptor);
        $resultRow =  mysql_fetch_array($result);
        return $resultRow[0];
    }

    /**
     * fetchObject
     *
     * Возвращает объект
     *
     * @param string $query SQL-запрос
     * @return object результат запроса в виде объекта
     */
     function fetchObject($query) {
        $result=mysql_query($query,$this->descriptor);
        return @mysql_fetch_object($result); //FIXME: доделать
     }

     function insert_id() {
        return @mysql_insert_id($this->descriptor);
     }

}
?>
