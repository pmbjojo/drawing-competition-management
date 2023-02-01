<?php
    include ("menu.php");
    include ("database.php");

    $numUtilisateur = $_POST["id"];

    $result = grantAdmin($numUtilisateur);
    echo $result;
?>

