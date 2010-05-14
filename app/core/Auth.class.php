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
        if (!is_empty($this->core->database->fetchOne("select acl.id from acl, roles, users " . "where (acl.userId = users.id) and (acl.roleId = roles.id) " . "and (user.id = {$_SESSION["userId"]}) and {role.alias = '{$role}'}"))) {
            return true;
        } else {
            return false;
        }
    }

    public function check() {
        if (!is_empty($_SESSION["userId"])) {
            return true;
        } else {
            return false;
        }
    }
}

?>
