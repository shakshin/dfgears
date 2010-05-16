<?php
class DFCore {

    public $auth;
    public $aliases;
    public $database;
    public $config;
    public $request;
    public $pageTitle= "dfGears page";
    public $content = "";

    private $hooks = array();
    private $isAjax = false;

    private $mail;

    public function run() {
        session_start();
        // Добавление своих путей с инклюдами
        $this->addIncludePath("app/core");
        $this->addIncludePath("app/modules");
        $this->addIncludePath("app/config");

        // Подключение gears
        if ($gearsDir = opendir("app/modules/gears")) {
            while (false != ($gear = readdir($gearsDir))) {
                if ((preg_match("/^[^_].+\.php$/", $gear) > 0) && (!is_dir("modules/gears" . $gear))) {
                    include_once "app/modules/gears/" . $gear;
                }
            }
            closedir($gearsDir);
        }

        // Подключение прототипа модулей
        require_once "Module.class.php";
        require_once "Templater.class.php";
        require_once "Database.class.php";
        require_once "Context.class.php";
        require_once "Auth.class.php";
        require_once "Mail.class.php";

        $this->configure();
        $this->pageTitle = $this->config->defaultTitle;

        
        // Инициализация адаптера БД
        
        require_once "Database.".$this->config->database->system.".class.php";
        $this->database = new $this->config->database->system($this);
        $this->database->connect();

        // Подключение системы авторизации
        $this->auth = new DFAuth($this);

        // чтение параметров
        // сначала _GET, затем _POST - последние накладываются поверх и более приоритетны
        $ctx = new DFContext();
        $ctx = $this->hookTouch("before_prarams_load", $ctx);
        
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


        // подключения модуля и генерация контента
        if (isset($this->request->parameters["alias"])) {
            $alias = $this->request->parameters["alias"];
        } else {
            $alias = $this->config->defaultObject;
        }
        
        $this->content = $this->moduleAction($this->aliases[$alias], $this->request->parameters["action"]);

        if (!$this->isAjax) {
            $tpl = new DFTemplater();
            $tpl->assign("pageTitle", $this->pageTitle);
            $tpl->assign("userName", $_SESSION["userName"]);
            $tpl->assign("content", $this->content);
            return $tpl->fetch("main");
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
    public function hookSubscribe($alias, $handler) {
        $this->hooks[$alias][] = $handler;
    }

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

    public function moduleAction($module, $action) {
        if (empty($module)) {
            $this->setAjax();
            header("HTTP/1.0 404 Not Found");
            return;
        }
        if (!file_exists("app/modules/" . $module . ".module.php")) {
            $this->setAjax();
            header("HTTP/1.0 404 Not Found");
            return;
        }
        require_once "app/modules/" . $module . ".module.php";
        $moduleInstance = new $module($this);
        return $moduleInstance->action($action);

    }

    public function sendMail($to, $subj, $message) {      
        $m = new Mail();
        $m->From($this->config->mailFrom);
        $m->To($to);
        $m->Subject($subj);
        $m->Body($message, "UTF-8");
        $m->Send();
    }
}

?>