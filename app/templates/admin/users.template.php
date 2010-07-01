<table class="data">
    <tr  class="head">
        <td>id</td>
        <td>Имя</td>
        <td>Ник</td>
        <td>e-mail</td>
    </tr>
<? foreach ($items as $item) { ?>
    <tr>
        <td><?=$item["id"] ?></td>
        <td><?=$item["login"] ?></td>
        <td><?=$item["fullName"] ?></td>
        <td><?=$item["email"] ?></td>
        <td>
            <a href="/admin/userDelete/<?=$item["id"] ?>">Удалить</a> |
            <a href="/admin/userActivate/<?=$item["id"] ?>">Активировать</a> |
            <a href="/admin/userRoles/<?=$item["id"] ?>">Роли</a>
        </td>
    </tr>
<? } ?>
</table>
