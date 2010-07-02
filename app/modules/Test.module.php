<?php
class test extends DFModule {

    public function main() {
        $image = new DFImage("/var/www/test.jpg");

        $this->core->setAjax();
        $image->thumbnail(100, 200);
        $image->toClient();
    }
}

?>