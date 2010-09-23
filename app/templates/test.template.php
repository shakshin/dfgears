
<h1>Доступные методы тестового модуля:</h1>
<ul>
<?

foreach ($tests as $test) {
    ?><li><a href="/test/<?=$test ?>"><?=$test ?></a></li><?
}

?>
</ul>
