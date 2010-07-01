<form method="POST" action="/admin/roleAdd">
<table class="data">
    <tr  class="head">
        <td>id</td>
        <td>Имя</td>
        <td>Читаемое имя</td>
    </tr>
<? foreach ($items as $item) { ?>
    <tr>
        <td><?=$item["id"] ?></td>
        <td><?=$item["alias"] ?></td>
        <td><?=$item["fullName"] ?></td>
        <td>
            <a href="/admin/roleDelete/<?=$item["id"] ?>">Удалить</a>
        </td>
    </tr>
<? } ?>
    <tr>
        <td></td>
        <td><input name="roleName"></td>
        <td><input name="roleFullName"</td>
        <td>
            <input type="submit" value="Добавить">
        </td>
    </tr>
</table>
</form>