<?php
class test extends DFModule {

    public function main() {
        $tpl = new DFTemplater();
        $tpl->assign("megatest", $this->core->config->database->className);
        return $tpl->fetch("Test");
    }
}

?>
