<?php
class test extends DFModule {

    public function main() {
        $tpl = new DFTemplater();
        $tpl->assign("megatest", $this->core->config->database->system);
        return $tpl->fetch("Test");
    }
}

?>