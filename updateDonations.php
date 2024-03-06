<?php
    session_start();
    include("php/config.php");

    $username = $_POST['username'];
    $name = $_POST['name'];
    $proion = $_POST['proion'];
    $atoma = $_POST['atoma'];

    mysqli_query($con, "DELETE FROM dorees WHERE username = '$username' AND onoma = '$name' AND proion = '$proion' AND atoma='$atoma'");
    mysqli_query($con, "DELETE FROM doreespolith WHERE username = '$username' AND proion = '$proion' AND atoma='$atoma'");


?>