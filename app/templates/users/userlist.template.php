<h2>
					Список пользователей
</h2>



<div class="c"></div>

<div class="b-obj-list">

    <table cellspacing="0">
        <thead>
            <tr>
                <th>
										id
                </th>
                <th>
										login
                </th>
                <th>
										Полное имя/ник
                </th>
                <th>
										Email
                </th>
                <th>
                    Действия
                </th>
            </tr>
        </thead>
        <tbody>
            <? foreach ($users as $user) {
 ?>
                <tr>
                    <td>
<?= $user["id"] ?>
                </td>
                <td>
<?= $user["login"] ?>
                </td>
                <td>
<?= $user["fullName"] ?>
                </td>
                <td>
                    <a href="mailto:<?= $user["email"] ?>"><?= $user["email"] ?></a>
                </td>
                <td>

                    <div class="b-actions l">
                        <div href="" class="b-button l">
                            <a href="/admin/users/deleteUser/id/<?=$user["id"] ?>">
                                <span>Удалить</span>
                            </a>
                        </div>

                        <hr class="l" />

                        <div class="c"></div>
                    </div>

                    <div class="b-actions l">
                        <div href="" class="b-button l">
                            <a href="/admin/users/activateUser/id/<?=$user["id"] ?>">
                                <span>Активировать</span>
                            </a>
                        </div>

                        <hr class="l" />

                        <div class="c"></div>
                    </div>
                </td>
            </tr>
<? } ?>
        </tbody>
    </table>

  

</div>
