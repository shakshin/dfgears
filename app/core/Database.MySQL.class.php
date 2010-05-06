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
 * @author Pavel Vyazovoi <vyazovoi@googlemail.com>
 * @version 0.1
 * @package Core
 * @todo fetchRow, fetchCol
 */
class MySQL extends Database {
    
    /**
     * Конструктор: инициализация подключения к базе данных
     */
    function __construct() {
        $this->descriptor=mysql_pconnect($db_host,$db_login,$db_password) or die(mysql_error()); // FIXME: заменить or die на вменяемый обработчик экзепшенов
        mysql_select_db($db_name,$this->descriptor);
        $this->exec("SET NAMES 'UTF8'");
        return 0;
    }
    
    /**
     * Exec
     * 
     * Функция выполняет запрос без обработки результата
     * 
     * @param string $query SQL-запрос
     */
    function exec($query) {
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
     * Возвращает весь рекордсет
     *
     * @param string $query SQL-запрос
     * @return array массив с результатом запроса
     */    
    function fetchAll($query) {
        $result=mysql_unbuffered_query($query,$this->descriptor);
        return @mysql_fetch_array($result);
    }
    
    /**
     * fetchRow
     *
     * Возвращает строку
     *
     * @param string $query SQL-запрос
     * @return array одномерный массив с результатом запроса
     */
    function fetchRow($query) {
        $result=mysql_unbuffered_query($query,$this->descriptor);
        return @mysql_fetch_array($result);
    }

}

?>