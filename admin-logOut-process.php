<?php 

session_start();

if (isset($_SESSION["service"])) {

    $_SESSION["service"] = null;
    session_destroy();

    echo("success");

}

?>