<?php
class Auth extends DFModule {
    public function main() {
        return $this->logon();
    }

    public function logon() {
        $_SESSION["userId"] = "";
        $_SESSION["userName"] = "";
        if (!empty($this->core->request->parameters["login"]) && !empty($this->core->request->parameters["password"]) ) {
            $login = $this->core->database->escape($this->core->request->parameters["login"]);
            $password = md5($this->core->request->parameters["password"]);
            $uid = $this->core->database->fetchOne(
                "select users.id from users " .
                "where (users.login='{$login}') " .
                "and (users.`password` = '{$password}') " .
                "and (users.active = 1)"
            );
            if (!empty($uid)) {
                $_SESSION["userId"] = $uid;
                $_SESSION["userName"] = $login;
                if (!empty($_SESSION["lastURI"])) {
                    header("Location: {$_SESSION["lastURI"]}");
                } else {
                    header("Location: /");
                }
                return;
            } else {
                 $tpl = new DFTemplater();
                 $tpl->assign("message", "<strong>Ошибка входа!</strong><br>Проверьте имя и пароль.");
                 $tpl->assign("login", $this->core->request->parameters["login"]);
                 $tpl->assign("password", $this->core->request->parameters["password"]);
                 $tpl->setPrefix("auth");
                 return $tpl->fetch("logon");
            }
        } else {
            $tpl = new DFTemplater();
            $tpl->assign("message", "Введите ваше имя пользователяи пароль");
            $tpl->assign("login", "");
            $tpl->assign("password", "");
            $tpl->setPrefix("auth");
            return $tpl->fetch("logon");
        }
    }

    public function logoff() {
        $_SESSION["userId"] = "";
        $_SESSION["userName"] = "";
        header("Location: /");
    }

    public function register() {
        $message = "";
        $lcheck = $this->core->database->fetchOne("select id from users where login='{$this->core->database->escape($this->core->request->parameters["login"])}'");
        $ncheck = $this->core->database->fetchOne("select id from users where fullName='{$this->core->database->escape($this->core->request->parameters["fullName"])}'");
        if (empty($this->core->request->parameters["reg"])) {
            $message = "Заполните анкету регистрации пользователя";
        } else
        if (empty($this->core->request->parameters["login"])) {
            $message = "Введите желаемое имя пользователя";
        } else
        if (empty($this->core->request->parameters["password"])) {
            $message = "Введите желаемый пароль";
        } else
        if ($this->core->request->parameters["password2"] != $this->core->request->parameters["password"]) {
            $message = "Пароль и подтверждение не совпадают!";
        } else
        if (empty($this->core->request->parameters["fullName"])) {
            $message = "Введите Ваш ник";
        } else
        if (empty($this->core->request->parameters["email"])) {
            $message = "Введите Ваш e-mail";
        } else
        if (!check_email_address($this->core->request->parameters["email"])) {
            $message = "Введенный email неверен. Проверьте или введите другой";
        } else
        if (!preg_match("/^[a-zA-Z]+[a-zA-Z0-9\.\-_]+$/", $this->core->request->parameters["login"])) {
            $message = "Введенное имя пользователя неверно. Проверьте или введите другое";
        } else
        if (!preg_match("/^[a-zA-Z0-9]+[a-zA-Z0-9\.\-=]$/", $this->core->request->parameters["fullName"])) {
            $message = "Введенный ник неверен. Проверьте или введите другой";
        } else
        if (!empty($lcheck)) {
            $message = "Введенное имя пользователя уже занято. Введите другое";
        } else
        if (!empty($ncheck)) {
            $message = "Введенный ник уже занят. Введите другой";
        }


        if (empty($message)) {
            $login = $this->core->database->escape($this->core->request->parameters["login"]);
            $password = md5($this->core->request->parameters["password"]);
            $fullName = $this->core->database->escape($this->core->request->parameters["fullName"]);
            $email = $this->core->database->escape($this->core->request->parameters["email"]);
            $code = md5($login.$password.date("d-m-Y:H-i-s"));
            
            $this->core->database->exec("insert into users (login, `password`, fullName, email, active, code) values ('{$login}', '{$password}', '{$fullName}', '{$email}', 0, '{$code}')");
            $this->core->sendMail($this->core->request->parameters["email"], "Регистрация на сайте {$this->core->config->publicURL}", "Ваша ссылка активации: {$this->core->config->publicURL}/user/activate?code={$code}");
            return "<p class='b-centered'>Ваша учетная запись создана, но еще не активна.<br>На указзанный email выслана ссылка для активации.</p>";
        } else {
            $tpl = new DFTemplater();
            $tpl->assign("message", $message);
            $tpl->assign("login", $this->core->request->parameters["login"]);
            $tpl->assign("fullName", $this->core->request->parameters["fullName"]);
            $tpl->assign("email", $this->core->request->parameters["email"]);

            $tpl->setPrefix("auth");
            return $tpl->fetch("register");
        }
    }

    public function activate() {
        if (empty($this->core->request->parameters["code"])) {
            header("Location: /");
        } else {
            $code=$this->core->database->escape($this->core->request->parameters["code"]);
            $uid = $this->core->database->fetchOne("select id from users where (active=0) and (code='{$code}')");
            if (empty($uid)) {
                header("Location: /");
            } else {
                $role = $this->core->database->fetchOne("select id from roles where (alias='user')");
                if (!empty($role)) {
                    $this->core->database->exec("insert into acl (userId, roleId) values ({$uid}, {$role})");
                }

                $this->core->database->exec("update users set active=1, code='' where (id={$uid})");
                return "<p class='b-centered'>Ваша учетная запись активирована!<br>Теперь вы можете <a href='/user/logon'>войти</a> на сайт.</p>";
            }

        }
    }

    public function profile() {
        if (!$this->core->auth->check()) {
            return $this->logon();

        }
        $message = "";


        if (empty($this->core->request->parameters["reg"])) {
            $message = "Заполните поля профиля";
        } else
        if (empty($this->core->request->parameters["password"])) {
            $message = "Введите желаемый пароль";
        } else
        if ($this->core->request->parameters["password2"] != $this->core->request->parameters["password"]) {
            $message = "Пароль и подтверждение не совпадают!";
        } else
        if (empty($this->core->request->parameters["fullName"])) {
            $message = "Введите Ваш ник";
        } else
        if (empty($this->core->request->parameters["email"])) {
            $message = "Введите Ваш e-mail";
        } else
        if (!check_email_address($this->core->request->parameters["email"])) {
            $message = "Введенный email неверен. Проверьте или введите другой";
        } else
        if (!preg_match("/^[a-zA-Z0-9]+[a-zA-Z0-9\.\-=]$/", $this->core->request->parameters["fullName"])) {
            $message = "Введенный ник неверен. Проверьте или введите другой";
        }



        if (empty($message)) {
            $id = $_SESSION["userId"];
            $login = $_SESSION["userName"];
            $password = md5($this->core->request->parameters["password"]);
            $fullName = $this->core->database->escape($this->core->request->parameters["fullName"]);
            $email = $this->core->database->escape($this->core->request->parameters["email"]);

            $this->core->database->exec("update users set `password` = '{$password}', fullName = '{$fullName}', email = '{$email}' where id = {$id}");

            return "<p class='b-centered'>Ваша учетная запись успешно изменена.</p>";
        } else {
            $pr = $this->core->database->fetchRow("select * from users where id = {$_SESSION["userId"]}");

            $tpl = new DFTemplater();
            $tpl->assign("message", $message);
            $tpl->assign("login", $_SESSION["userName"]);
            $tpl->assign("id", $_SESSION["userId"]);
            $tpl->assign("fullName", $pr["fullName"]);
            $tpl->assign("email", $pr["email"]);
            $tpl->setPrefix("auth");
            return $tpl->fetch("profile");
        }
    }
  
}

?>
