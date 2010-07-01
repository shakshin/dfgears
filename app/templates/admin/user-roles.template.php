<h1>Роли пльзователя <?=$login ?></h1>
<form method="POST" action="/admin/userRoleAdd">
<input type="hidden" name="user" value="<?=$uid?>">
<table class="data">
<? foreach ($items as $item) { ?>
    <tr>
        <td><?=$item["alias"] ?></td>
        <td><?=$item["fullName"] ?></td>
        <td>
            <a href="/admin/userRoleDelete/<?=$item["userId"] ?>/<?=$item["roleId"] ?>">Удалить</a>
        </td>
    </tr>
<? } ?>
    <tr>
        <td></td>
        <td><select name="role">
                <? foreach ($freeRoles as $role) { ?>
                <option value="<?=$role["id"] ?>"><?=$role["alias"] ?> (<?=$role["fullName"] ?>)</option>
                <? } ?>
            </select></td>
        <td>
            <input type="submit" value="Добавить">
        </td>
    </tr>
</table>
</form>