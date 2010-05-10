<?php



class DFCore {
    public $database;
    public $config;
    public $request;

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

        $this->configure();

        // Инициализация адаптера БД
        require_once "Database.class.php";
        require_once "Database.".$this->config->database->system.".class.php";
        $this->db = new $this->config->database->system();

        //отладка
        return $this->moduleAction("Test", "");

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


// TODO: дописать механизм хуков
/*    public function hookSubscribe($alias, $handler) {
        $this->hooks[$alias][] = $handler;
    }

    public function hookTouch($alias, $context) {
        foreach ($this->hooks[$alias] as $handler) {
            $context = $handler($this, $context);
        }
        return $context;
    }
*/
    public function moduleAction($module, $action) {
        require_once $module . ".module.php";
        $moduleInstance = new $module($this);
        return $moduleInstance->action($action);
    }
}

?>