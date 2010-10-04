<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title><?=$this->vars["pageTitle"] ?></title>
	</head>
	<body>
            <div align="right">
                <a href="/">/</a>
                <?
                if ($this->core->auth->check()) {
                ?>
                    <a href="/user/profile"><?=$_SESSION["userName"] ?></a>
                    <a href="/user/logoff">Выход</a>
                <?
                } else {
                ?>
                    <a href="/user/logon">Вход</a>
                <?    
                }
                ?>
            </div>
            <hr/>
            <?=$content ?>
            <hr/>
            <address>dfgears engine v<?=$this->cor->version ?> &copy; <a href="http://diffy.ru">Different</a>; original code by <a href="mailto:shakshin@diffy.ru">Sergei Shakshin</a></address>
        </body>
</html>