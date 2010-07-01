<h2>Профиль пользователя</h2>
<p class="b-centered">
    <?=$this->vars["message"] ?>
</p>

<form method="POST" action ="">
    <input type="hidden" name="reg" value="reg">
    <p class="b-centered">
    Имя пользователя: <?=$this->vars["login"] ?><br><br>
    Пароль:<br><input type="password" name="password" value=""><br>
    Подтверждение пароля:<br><input type="password" name="password2" value=""><br>
    Ник:<br><input name="fullName" value="<?=$this->vars["fullName"] ?>"><br>
    E-mail:<br><input name="email" value="<?=$this->vars["email"] ?>"><br>
    ICQ:<br><input name="icq" value="<?=$this->vars["icq"] ?>"><br><br>
    <input type="submit" value="Сохранить">
    </p>
    
</form>
