<?php
class test extends DFModule {

    public function main() {
        $link = new DFLink();
        $link->external("http://test.bla");
        $link->option("byRating");
        $link->param("test", "kkjhkjhkjh!!!???");
        $link->classic();
        $url = $link->render();
        ?><a href="<?=$url ?>">test</a><?
    }
}

?>