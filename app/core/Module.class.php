<?php
abstract class DFModule {
    protected $core;
    protected $id;

    function DFModule($core) {
        $this->core = $core;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function action($action) {
        if (empty($action)) { $action = "main"; }
        if (method_exists($this, $action)) {
            return $this->$action();
        } else {
            throw new Exception("Method not found: {$action}");
        }
    }
}
?>
