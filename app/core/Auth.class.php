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
        $acl = $this->core->database->fetchOne("select acl.id from acl, roles, users " . "where (acl.userId = users.id) and (acl.roleId = roles.id) " . "and (user.id = {$_SESSION["userId"]}) and {role.alias = '{$role}'}");
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
