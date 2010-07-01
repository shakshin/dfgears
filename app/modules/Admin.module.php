<?php
    class Admin extends DFModule {
        protected $roleRequired = "admin";

        public function main() {
            return $this->roles();
        }

        public function roles() {
            $this->core->setMainTemplate("admin");

            $items = $this->core->database->fetchAll("select * from roles");

            $tpl = new DFTemplater();
            $tpl->setPrefix("admin");
            $tpl->assign("items", $items);
            return $tpl->fetch("roles");
        }

        public function roleAdd() {
            if (isset($this->core->request->parameters["roleName"]) && isset($this->core->request->parameters["roleFullName"])) {
               $this->core->database->exec("insert into roles (alias, fullName) values ('{$this->core->request->parameters["roleName"]}', '{$this->core->request->parameters["roleFullName"]}')");
            }
            return $this->roles(); 
        }

        public function roleDelete() {
            if (isset($this->core->request->parsed[0])) {
                $this->core->database->exec("delete from roles where id = {$this->core->request->parsed[0]}");
                $this->core->database->exec("delete from acl where roleId = {$this->core->request->parsed[0]}");
            }
            return $this->roles();
        }

        public function users() {
            $this->core->setMainTemplate("admin");

            $items = $this->core->database->fetchAll("select * from users");

            $tpl = new DFTemplater();
            $tpl->setPrefix("admin");
            $tpl->assign("items", $items);
            return $tpl->fetch("users");
        }

        public function userDelete() {
            if (isset($this->core->request->parsed[0])) {
                $this->core->database->exec("delete from users where id = {$this->core->request->parsed[0]}");
                $this->core->database->exec("delete from acl where userId = {$this->core->request->parsed[0]}");
            }
            return $this->users();
        }

        public function userActivate() {
            if (isset($this->core->request->parsed[0])) {
                $this->core->database->exec("update users set active=1 where id = {$this->core->request->parsed[0]}");
            }
            return $this->users();
        }

        public function userRoles() {
            $this->core->setMainTemplate("admin");
            if (isset($this->core->request->parsed[0])) {
                $uid = $this->core->request->parsed[0];
                $login = $this->core->database->fetchOne("select login from users where id={$uid}");
                $items = $this->core->database->fetchAll("select * from acl, roles where (roles.id=acl.roleId) and (acl.userId={$uid})");
                $broles = array();
                foreach ($items as $item) {
                    $broles[] = $item["id"];
                }
                $roles = $this->core->database->fetchAll("select * from roles");
                $freeRoles = array();
                foreach ($roles as $role) {
                    if (!in_array($role["id"], $broles)) {
                        $freeRoles[] = $role;
                    }
                }
                $tpl = new DFTemplater();
                $tpl->setPrefix("admin");
                $tpl->assign("items", $items);
                $tpl->assign("uid", $uid);
                $tpl->assign("login", $login);
                $tpl->assign("freeRoles", $freeRoles);
                return $tpl->fetch("user-roles");
            } else { return $this->users(); }
        }

        public function userRoleAdd() {
            if (isset($this->core->request->parameters["user"]) && isset($this->core->request->parameters["role"])) {
               $this->core->database->exec("insert into acl (userId, roleId) values ('{$this->core->request->parameters["user"]}', '{$this->core->request->parameters["role"]}')");
            }
            header("Location: /admin/userRoles/{$this->core->request->parameters["user"]}");
            return;
        }

        public function userRoleDelete() {
            if (isset($this->core->request->parsed[0]) && isset($this->core->request->parsed[1])) {
               $this->core->database->exec("delete from acl where userID={$this->core->request->parsed[0]} and roleId = {$this->core->request->parsed[1]}");
            }
            header("Location: /admin/userRoles/{$this->core->request->parsed[0]}");
            return;
        }
    }

?>
