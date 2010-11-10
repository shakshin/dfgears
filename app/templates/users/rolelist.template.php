<h2>
					Список ролей
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
										Алиас
                </th>
                <th>
										Низвание
                </th>
                <th>
                    Действия
                </th>
            </tr>
        </thead>
        <tbody>
            <? foreach ($roles as $role) {
 ?>
                <tr>
                    <td>
<?= $role["id"] ?>
                </td>
                <td>
<?= $role["alias"] ?>
                </td>
                <td>
<?= $role["fullName"] ?>
                </td>
                <td>

                    <div class="b-actions l">
                        <div href="" class="b-button l">
                            <a href="/admin/users/deleteRole/id/<?=$role["id"] ?>">
                                <span>Удалить</span>
                            </a>
                        </div>

                        <hr class="l" />

                        <div class="c"></div>
                    </div>
                    <div class="b-actions l">
                        <div href="" class="b-button l">
                            <a href="/admin/users/updRole/id/<?=$role["id"] ?>">
                                <span>Редактировать</span>
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


  <div href="" class="b-button l">
     <a href="/admin/users/addRole/">
       <span>Добавить</span>
     </a>
  </div>
  <div class="c"></div>

</div>
