<?php
class Users extends DFModule {
    public $roleRequired = "admin";
    public $title = "Пользователи";
    public $menu = array(
        "Список пользователей" => "listUsers",
        "Список ролей" => "listRoles"
    );

    public function listUsers() {
        $users = $this->core->database->fetchAll("select * from users order by login");
        $tpl = new DFTemplater();
        $tpl->assign("users", $users);
        $tpl->setPrefix("users");
        return $tpl->fetch("userlist");
    }

    public function activateUser() {
        $id = $this->core->request->parameters["id"];
        if (!empty($id)) {
            $id++; $id--;
            $this->core->database->exec("update users set active=1 where id={$id}");
        }
        header("Location: /admin/users/listUsers");
    }

    public function deleteUser() {
        $id = $this->core->request->parameters["id"];
        if (!empty($id)) {
            $id++; $id--;
            $this->core->database->exec("delete from users where id={$id}");
        }
        header("Location: /admin/users/listUsers");
    }

    public function listRoles() {

    }
}
?>
