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
            $className = get_class($this);
            $this->core->doError("call to undefined module action.<br/>module: {$className}<br/>action: {$action}");
        }
    }
}
?>
