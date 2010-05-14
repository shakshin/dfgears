<h2>Регистрация на сайте</h2>
<p class="b-centered">
    <?=$this->vars["message"] ?>
</p>

<form method="POST" action ="">
    <input type="hidden" name="reg" value="reg">
    <p class="b-centered">
    Имя пользователя:<br><input name="login" value="<?=$this->vars["login"] ?>"><br>
    Пароль:<br><input type="password" name="password" value=""><br>
    Подтверждение пароля:<br><input type="password" name="password2" value=""><br>
    Ник:<br><input name="fullName" value="<?=$this->vars["fullName"] ?>"><br>
    E-mail:<br><input name="email" value="<?=$this->vars["email"] ?>"><br><br>
    <input type="submit" value="Зарегистриоваться">
    </p>
</form>
