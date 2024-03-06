<?php
    session_start();
    include("php/config.php");

    $carId = $_POST['carId'];
    $taskId = $_POST['taskId'];
    $taskType = $_POST['taskType'];
    $citizenName = $_POST['citizenName'];
    $citizenMobile = $_POST['citizenMobile'];
    $proion = $_POST['proion'];
    $atoma = $_POST['atoma'];

    mysqli_query($con, "UPDATE tasks SET task_status = 'COMPLETE' WHERE id_task = '$taskId'");

    if($taskType === 'Request'){
        mysqli_query($con, "UPDATE aithmata SET hmerominia_oloklirosis = current_timestamp() WHERE onoma = '$citizenName' AND mobile = '$citizenMobile' AND proion = '$proion'");
        mysqli_query($con, "DELETE FROM loads  WHERE car_id = '$carId' AND pr_name = '$proion' AND quantity = '$atoma'");
    }else{
        mysqli_query($con, "UPDATE dorees SET hmerominia_oloklirosis = current_timestamp() WHERE onoma = '$citizenName' AND mobile = '$citizenMobile' AND proion = '$proion'");
        mysqli_query($con, "INSERT INTO loads(car_id, pr_name, quantity) VALUES('$carId', '$proion', '$atoma')"); 
    }
?>