
<h1>Пользователи системы:</h1>
<table border="1">
    <tr>
        <th>Id</th>
        <th>Имя пользователя</th>
        <th>E-mail</th>
    </tr>
<?

foreach ($users as $user) {
?>
    <tr>
        <td><?=$user["id"] ?></td>
        <td><?=$user["login"] ?></td>
        <td><a href="mailto:<?=$user["email"] ?>"><?=$user["email"] ?></a></td>
    </tr>
<?

}

?>
</table>
