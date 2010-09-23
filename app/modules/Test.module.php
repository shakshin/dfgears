<?php
class Test extends DFModule {

    public function dbtest() {
        $users = $this->core->database->fetchAll("
            SELECT * FROM users ORDER BY id
        ");
        $tpl = new DFTemplater();
        $tpl->assign("users", $users);
        $tpl->setPrefix("test");
        return $tpl->fetch("dbtest");
    }

    public function main() {
        $methods = get_class_methods($this);
        unset($methods[array_search("action", $methods)]);
        unset($methods[array_search("DFModule", $methods)]);

        $tpl = new DFTemplater();
        $tpl->assign("tests", $methods);
        return $tpl->fetch("test");
    }
}

?>