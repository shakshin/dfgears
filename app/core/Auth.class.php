<?php
class DFAuth {
    private $core;

    function DFAuth($core) {
        $this->core = $core;
    }

    public function checkRole($role) {
        if (!$this->check()) {
            return false;
        }
        $acl = $this->core->database->fetchOne("select acl.roleid from acl, roles, users where (acl.userId = users.id) and (acl.roleId = roles.id) and (users.id = {$_SESSION["userId"]}) and (roles.alias = '{$role}')");
        if (!empty($acl)) {
            return true;
        } else {
            return false;
        }
    }

    public function check() {
        if (!empty($_SESSION["userId"])) {
            return true;
        } else {
            return false;
        }
    }
}

?>
