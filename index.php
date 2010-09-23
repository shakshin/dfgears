<?php
    ob_start();
    require_once "app/core/Core.class.php";
    $application = new DFCore();
    echo $application->run();
    ob_end_flush();
?>  