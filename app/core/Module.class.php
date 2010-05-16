<?php
abstract class DFModule {
    protected $core;

    function DFModule($core) {
        $this->core = $core;
    }

    public function action($action) {
        if (empty($action)) { $action = "main"; }
        if (method_exists($this, $action)) {
            return $this->$action();
        } else {
            $this->core->setAjax();
            header("HTTP/1.0 404 Not Found");
            return;
        }
    }
}
?>
