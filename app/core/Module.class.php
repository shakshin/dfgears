<?php
abstract class DFModule {
    protected $core;

    public $modName = "Untitled Module";

    protected $roleRequired = null;

    function DFModule($core) {
        $this->core = $core;
    }

    public function action($action) {
        if (($this->roleRequired != null) && (!$this->core->auth->checkRole($this->roleRequired))) {
            if ($this->core->auth->check()) {
                $this->core->doError("У Вас нет доступа к этой странице<br/>You are not alowed to access this content", "HTTP/1.0 403 Forbidden");
            } else {
                $_SESSION["lastURI"] = $uri = $_SERVER["REQUEST_URI"];
                header("Location: /user/logon");
            }
        }
        if (empty($action)) { $action = "main"; }
        if (method_exists($this, $action)) {
            return $this->$action();
        } else {
            $className = get_class($this);
            $this->core->doError("call to undefined module action.<br/>module: {$className}<br/>action: {$action}");
        }
    }
}
?>
