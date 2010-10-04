<?php
class Admin extends DFModule {
    public $roleRequired = "admin";
    public $title = null;
    public $menu = array();

    public function main() {
        return "DFGears v".$this->core->version."<br>Administrator interface";
    }


}

?>
