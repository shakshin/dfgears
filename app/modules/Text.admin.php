<?php

class Text extends DFModule {
    public $roleRequired = "admin";
    public $title = "Тексты";
    public $menu = array(
        "Новый текст" => "newText",
        "Все тексты" => "listAll"
    );

    public function main() {
        return $this->listAll();
    }

    public function newText() {
        $tpl = new DFTemplater();
        $tpl->assign("action", "saveNew");
        $tpl->setPrefix("text");

        return $tpl->fetch("edit");
    }

    public function listAll() {
        $texts = $this->core->database->fetchAll(
                "select text.id, alias, title, users.login as author, DATE_FORMAT(dt,'%e.%m.%Y, %k:%i') as dt from text, users where (users.id=text.author) order by alias");
        $tpl = new DFTemplater();
        $tpl->setPrefix("text");
        $tpl->assign("texts", $texts);
        
        return $tpl->fetch("list");
    }

    public function edit() {
        $id = $this->core->request->parameters["id"];
        if (empty($id)) {
            header("Location: /admin/text/listAll");
            return;
        }
        $txt = $this->core->database->fetchRow("select * from text where id = {$id}");
        extract($txt);
        $tpl = new DFTemplater();
        $tpl->setPrefix("text");
        $tpl->assign("action", "saveExist");
        $tpl->assign("id", $id);
        $tpl->assign("talias", $alias);
        $tpl->assign("title", $title);
        $tpl->assign("text", $text);
        return $tpl->fetch("edit");
    }

    public function delete() {
        $id = $this->core->request->parameters["id"];
        if (!empty($id)) {
            $this->core->database->exec("delete from text where id = {$id}");
        }
        header("Location: /admin/text/listAll");
    }

    public function saveNew() {
        $message = null;

        $talias = $this->core->request->parameters["talias"];
        $title = $this->core->request->parameters["title"];
        $text = $this->core->request->parameters["text"];
        $author = $_SESSION["userId"];

        if (empty($talias)) {
            $message = "Необходимо указать имя текста в системе";
        }
        if (empty($title)) {
            $message = "Необходимо указать заголовок текста";
        }
        if (empty($text)) {
            $message = "Необходимо ввести текст";
        }
        if (!empty($message)) {
            $tpl = new DFTemplater;
            $tpl->setPrefix("text");
            $tpl->assign("action", "saveNew");
            $tpl->assign("talias", $talias);
            $tpl->assign("title", $title);
            $tpl->assign("text", $text);
            return $tpl->fetch("edit");
        } else {
            
            $this->core->database->exec(
                "insert into text (alias, title, text, author, dt) " .
                "values ('{$talias}', '{$title}', '{$text}', {$author}, NOW())"
            );
            header("Location: /admin/text/listAll");
        }
    }

    public function saveExist() {
        $message = null;
        $id = $this->core->request->parameters["id"];
        $talias = $this->core->request->parameters["talias"];
        $title = $this->core->request->parameters["title"];
        $text = $this->core->request->parameters["text"];
        $author = $_SESSION["userId"];

        if (empty($talias)) {
            $message = "Необходимо указать имя текста в системе";
        }
        if (empty($title)) {
            $message = "Необходимо указать заголовок текста";
        }
        if (empty($text)) {
            $message = "Необходимо ввести текст";
        }
        if (!empty($message)) {
            $tpl = new DFTemplater;
            $tpl->setPrefix("text");
            $tpl->assign("action", "saveExist");
            $tpl->assign("talias", $talias);
            $tpl->assign("title", $title);
            $tpl->assign("text", $text);
            return $tpl->fetch("edit");
        } else {
            
            $this->core->database->exec(
                "update text set alias='{$talias}', title='{$title}', text='{$text}', author={$author}, dt=NOW() where id={$id}"
            );
            header("Location: /admin/text/listAll");
        }
    }
}

?>
