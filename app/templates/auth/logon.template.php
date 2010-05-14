<h2>Вход на сайт</h2>
<p class="b-centered">
    <?=$this->vars["message"] ?>
</p>

<form method="POST" action ="">
    <p class="b-centered">
    Имя пользователя:<br><input name="login" value="<?=$this->vars["login"] ?>"><br>
    Пароль:<br><input type="password" name="password" value="<?=$this->vars["password"] ?>"><br><br>
    <input type="submit" value="Войти">
    </p>
</form>
<p class="b-centered">
    Первый раз на сайте? <a href="/user/register">Зарегистрируйтесь!</a>
</p>