<h1>Список пользователей</h1>
<table class="data">
    <tr>
        <th>id</th>
        <th>login</th>
        <th>Полное имя/ник</th>
        <th>E-mail</th>
    </tr>

<? foreach ($users as $user) {?>
    <tr>
        <td><?=$user["id"] ?></td>
        <td><?=$user["login"] ?></td>
        <td><?=$user["fullName"] ?></td>
        <td><a href="mailto:<?=$user["email"]?>"><?=$user["email"] ?></a></td>
        <td>
            [&nbsp;<a href="/admin/users/deleteUser/id/<?=$user["id"] ?>">Удалить</a>&nbsp;]
            <? if ($user["active"] == 0) { ?>
            [&nbsp;<a href="/admin/users/activateUser/id/<?=$user["id"] ?>">Активировать</a>&nbsp;]
            <? } ?>
        </td>
    </tr>
<? } ?>
</table>
