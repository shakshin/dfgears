<h1>Редактирование текста</h1>
<script type="text/javascript" charset="utf-8" src="/js/tiny_mce/jquery.tinymce.js"></script>
<hr/>
<? if (!empty($message)) { ?>
<strong><?=$message ?></strong>
<hr/>
<? } ?>
<form action="/admin/text/<?=$action?>" method="post">
    <input type="hidden" name="id" value="<?=$id ?>"/>
    Имя текста<br/>
    <input name="talias" value="<?=$talias ?>" maxlength="20"/><br/>
    Заголовок<br/>
    <input name="title" value="<?=$title ?>" maxlength="250"/><br/>
    Текст<br/>
    <textarea id="editor" name="text" rows="20" cols="100" style="font-size: 12pt;"><?=$text ?></textarea><br>
    <input type="submit" value="Сохранить"/>
</form>

<script>
    $(document).ready(function() {
        $("#editor").tinymce({
            script_url: '/js/tiny_mce/tiny_mce.js',
            theme: 'advanced',
            theme_advanced_toolbar_location : "top",
            theme_advanced_toolbar_align : "left",
            theme_advanced_statusbar_location : "bottom"
        });
      });
</script>