<?php
/**
 *
 * DFCore
 *
 * Класс ядра DFGears.
 * Предоставляет публичные методы:
 * 1) run()             - запуск ядра
 * 2) setAjax()         - выставить флаг AJAX
 * 3) addIncludePath()  - добавить путь для подключения внешних модулей
 * 4) hookSubscribe()   - подбавить обработчик для точки перехвата
 * 5) hookTouch()       - активизировать точку перехвата
 * 6) sendMail()        - отправить сообщение по почте
 *
 */
class DFCore {
    public $version = "0.1a";
    /**
     *
     * Объект, отвечающий за авторизацию пользователей в системе
     *
     */
    public $auth;

    /**
     *
     * Список соответствия алиасов и модлуей их обрабатывающих
     *
     */
    public $aliases;

    /**
     *
     * Объект для доступа к БД
     *
     */
    public $database;

    /**
     *
     * Структура конфигурации ядра
     *
     */
    public $config;

    /**
     *
     * Параметры запроса
     *
     */
    public $request;

    /**
     *
     * Заголовок страницы
     *
     */
    public $pageTitle= "dfGears page";

    /**
     *
     * Контент страницы
     *
     */
    public $content = "";

    private $template = "main";

    private $tplVars = array();

    private $hooks = array();
    private $isAjax = false;

    private function init() {
        error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
        // Добавление своих путей с инклюдами
        $this->addIncludePath("app/core");
        $this->addIncludePath("app/modules");
        $this->addIncludePath("app/config");

        // Подключение ядерных классов
        if ($coreDir = opendir("app/core")) {
            while (false != ($class = readdir($coreDir))) {
                if ((preg_match("/^[^\.]+\.class\.php$/", $class) > 0) && (!is_dir("app/core/" . $class))) {
                    require_once "app/core/" . $class;
                }
            }
            closedir($coreDir);
        }

    }

    private function dbInit() {
        require_once "Database.".$this->config->database->system.".class.php";
        $this->database = new $this->config->database->system($this->config->database);
        return $this->database->connect();
    }

    private function parse() {
        // чтение параметров
        // сначала _GET, затем _POST - последние накладываются поверх и более приоритетны
        $ctx = new DFContext();
        $ctx = $this->hookTouch("before_params_load", $ctx);

        foreach ($_GET as $key => $value) {
            $this->request->parameters[$key] = $value;
        }
        foreach ($_POST as $key => $value) {
            $this->request->parameters[$key] = $value;
        }
        $ctx = new DFContext();
        $ctx->vars["parameters"] = $this->request->parameters;
        $ctx = $this->hookTouch("after_prarams_load", $ctx);
        $this->request->parameters = $ctx->vars["parameters"];

        // ЧПУ
        $uri = $_SERVER["REQUEST_URI"];
        $uri = preg_replace("/^\//", "", $uri);
        $uri = preg_replace("/\?.*$/", "", $uri);
        $uri = preg_replace("/\.html$/", "", $uri);
        $parsed = explode("/", $uri);

        // Проверка на aякс-флаг
        if (!empty($parsed[0]) && $parsed[0] == "ajax") {
            $this->setAjax();
            $parsed = array_slice($parsed, 1);
        }

        if (!empty($parsed[0])) {
            $this->request->parameters["alias"] = $parsed[0];
            if (!empty($parsed[1])) {
                $this->request->parameters["action"] = $parsed[1];
                $this->request->parsed = array_slice($parsed, 2);
            } else {
                $this->request->parsed = array_slice($parsed, 1);
            }
        } else {
            $this->request->parsed = array();
        }

        $i = 0;
        while (isset($this->request->parsed[$i])) {
            if (isset($this->request->parsed[$i+1])) {
                $this->request->parameters[$this->request->parsed[$i]] = $this->request->parsed[$i+1];
            }
            $i = $i+2;
        }
    }

    public function run() {
        session_start();
        // Инициализация
        $this->init();
        $GLOBALS["dfcore"] = $this;

        // Подключение gears
        if ($gearsDir = opendir("app/modules/gears")) {
            while (false != ($gear = readdir($gearsDir))) {
                if ((preg_match("/^[^_].+\.php$/", $gear) > 0) && (!is_dir("modules/gears" . $gear))) {
                    include_once "app/modules/gears/" . $gear;
                }
            }
            closedir($gearsDir);
        }
        // Конфигурирование
        $this->configure();
        $this->pageTitle = $this->config->defaultTitle;

        // Инициализация адаптера БД       
         if (!$this->dbInit()) {
             $this->doError("database connection failed");
             return;
         }

        // Подключение системы авторизации
        $this->auth = new DFAuth($this);

        $this->parse();

        // подключения модуля и генерация контента
        if (isset($this->request->parameters["alias"])) {
            $alias = $this->request->parameters["alias"];
        } else {
            $alias = $this->config->defaultObject;
            $this->request->parameters["alias"] = $this->config->defaultObject;
        }
        
        $this->content = $this->moduleAction($this->aliases[$alias], $this->request->parameters["action"]);

        if (!$this->isAjax) {
            $tpl = new DFTemplater();
            $tpl->assign("pageTitle", $this->pageTitle);
            $tpl->assign("userName", $_SESSION["userName"]);
            $tpl->assign("content", $this->content);
            foreach ($this->tplVars as $var => $value) {
                $tpl->assign($var, $value);
            }
            return $tpl->fetch($this->template);
        } else {
            return $this->content;
        }
    }

    public function setAjax() {
        $this->isAjax = true;
    }

    public function addIncludePath($path) {
        ini_set("include_path", ini_get("include_path") . PATH_SEPARATOR . $path);
    }

    private function configure() {
        include_once "Config.php";
        include_once "Config.route.php";
        $this->config = $cfg;
    }


    // Механизм хуков
    /**
     *
     * @param string $alias Алиас хука
     * @param string $handler Функция-обработчик хука
     */
    public function hookSubscribe($alias, $handler) {
        $this->hooks[$alias][] = $handler;
    }

    /**
     *
     * @param string $alias Алиас хука
     * @param string $context Контекст хука (набор переменных и объектов)
     */
    public function hookTouch($alias, $context) {
        if (!isset($this->hooks[$alias])) { return $context; }
        $newContext = $context;
        foreach ($this->hooks[$alias] as $handler) {
            $newContext = $handler($this, $newContext);
            if ($newContext->abort) {
                return $context;
                break;
            }
            if ($newContext->break) {
                return $newContext;
                break;
            }
        }
        return $newContext;
    }

    private function moduleAction($module, $action) {
        if (empty($module)) {
            $this->doError("module undefined: {$module}");
        }
        if (!file_exists("app/modules/" . $module . ".module.php")) {
            $this->doError("module not found: {$module}");
        }
        require_once "app/modules/" . $module . ".module.php";
        $moduleInstance = new $module($this);
        return $moduleInstance->action($action);

    }

    /**
     *
     * @param string $to Адресат
     * @param string $subj Тема
     * @param string $message Тело письма
     */
    public function sendMail($to, $subj, $message) {      
        $m = new Mail();
        $m->From($this->config->mailFrom);
        $m->To($to);
        $m->Subject($subj);
        $m->Body($message, "UTF-8");
        $m->Send();
    }

    /**
     *
     * @param string $message Сообщение об ошибке
     * @param string $response Заголовок ответа HTTP с кодом
     */
    public function doError($message = "core error", $response = "HTTP/1.0 500 Internal application error") {
        ob_end_clean();
        header($response);
        include "Error.php";
        exit();
    }

    /**
     *
     * @param string $template Имя шаблона
     */
    public function setMainTemplate($template) {
        $this->template = $template;
    }

    /**
     *
     * @param string $name Имя переменной
     * @param string $value Значение переменной
     */
    public function setTemplateVar($name, $value) {
        $this->tplVars[$name] = $value;
    }
}

?>
