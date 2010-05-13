<?php



class DFCore {
    public $database;
    public $config;
    public $request;
    public $pageTitle= "dfGears page";
    public $content = "";

    private $hooks = array();
    private $isAjax = false;

    public function run() {
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

        $this->configure();

        // Инициализация адаптера БД
        
        require_once "Database.".$this->config->database->system.".class.php";
        $this->database = new $this->config->database->system($this);
        $this->database->connect();

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

        // TODO: интерпретация ЧПУ


        // подключения модуля и генерация контента
        if (isset($this->request->parameters["alias"])) {
            $alias = $this->database->escape($this->request->parameters["alias"]);
        } else {
            $alias = $this->database->escape($this->config->deaultObject);
        }
        $req = $this->database->fetchRow("select objectClesses.module, objects.id from objectClasses, objects where (objects.class = objectClesses.id) and (object.alias = '$alias')");
        $module = $req[0];
        $id = $req[1];
        $this->content = $this->moduleAction($id, $module, $this->request->parameters["action"]);

        if (!$this->isAjax) {
            $tpl = new DFTemplater();
            $tpl->assign("pageTitle", $this->pageTitle);
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

// TODO: сделать автоподгрузку всех конфигов из папки config или догрузку по запросу модуля
        include_once "Config.php";
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

    public function moduleAction($id, $module, $action) {
        if (empty($id)) {
            throw new Exception("No object defined");
        }
        if (empty($module)) {
            throw new Exception("No module defined");
        }
        if (!file_exists("app/modules/" . $module . ".module.php")) {
            throw new Exception("Module not found: {$module}");
        }
        require_once "app/modules/" . $module . ".module.php";
        $moduleInstance = new $module($this);
        $moduleInstance.setId($id);
        return $moduleInstance->action($action);
    }
}

?>