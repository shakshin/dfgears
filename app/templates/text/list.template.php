<h1>
					Список текстов
</h1>



<div class="c"></div>

<div class="b-obj-list">

    <table cellspacing="0">
        <thead>
            <tr>
                <th>
										Имя
                </th>
                <th>
										Заголовок
                </th>
                <th>
										Автор
                </th>
                <th>
										Последняя правка
                </th>
                <th>
                    Действия
                </th>
            </tr>
        </thead>
        <tbody>
            <? foreach ($texts as $text) {
 ?>
                <tr>
                    <td>
<?=$text["alias"] ?>
                </td>
                <td>
<?=$text["title"] ?>
                </td>
                <td>
<?=$text["author"] ?>
                </td>
                <td>
<?=$text["dt"] ?>
                </td>
                <td>

                    <div class="b-actions l">
                        <div href="" class="b-button l">
                            <a href="/admin/text/delete/id/<?=$text["id"] ?>">
                                <span>Удалить</span>
                            </a>
                        </div>

                        <hr class="l" />

                        <div class="c"></div>
                    </div>

                    <div class="b-actions l">
                        <div href="" class="b-button l">
                            <a href="/admin/text/edit/id/<?=$text["id"] ?>">
                                <span>Править</span>
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
