<?php
    session_start();
    include("php/config.php");

    $taskId = $_POST['taskId'];
    $taskType = $_POST['taskType'];
    $citizenName = $_POST['citizenName'];
    $citizenMobile = $_POST['citizenMobile'];
    $proion = $_POST['proion'];

    mysqli_query($con, "DELETE FROM tasks WHERE id_task = '$taskId'");

    if($taskType === 'Request'){
        mysqli_query($con, "UPDATE aithmata SET egine_dekto ='' WHERE onoma = '$citizenName' AND mobile = '$citizenMobile' AND proion = '$proion'") or die("apotuxia");
    }else{
        mysqli_query($con, "UPDATE dorees SET egine_dekto ='' WHERE onoma = '$citizenName' AND mobile = '$citizenMobile' AND proion = '$proion'") or die("apotuxia");
    }
?>