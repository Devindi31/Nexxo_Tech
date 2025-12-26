<?php 

session_start();

if (isset($_SESSION["NexxoTechUser"])) {
    $_SESSION["NexxoTechUser"] = null;
    session_destroy();

    echo("success");
}

?>