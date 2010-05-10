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

    /**
     * Конструктор: инициализация подключения к базе данных
     */
    function connect() {
        $this->descriptor=mysql_pconnect($dbHost,$this->core->config->database->dbUser,$this->core->config->database->dbPassword) or die(mysql_error()); // FIXME: заменить or die на вменяемый обработчик экзепшенов
        mysql_select_db($this->core->config->database->dbName,$this->descriptor);
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

    // TODO: реализовать
    function fetchCol() {
        return 1;
    }

    // TODO: реализовать
    function fetchOne() {
        return 1;
    }

}

?>