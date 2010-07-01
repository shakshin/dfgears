<?php

class StaticPage extends DFModule {
    public function main() {
        $tpl = new DFTemplater();
        return $tpl->fetch($this->core->request->parameters["alias"]);
    }
}

?>
