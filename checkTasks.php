<?php
    include("php/config.php");
    $latitude = $_GET['latitude'];
    $longitude = $_GET['longitude'];
    $proion = $_GET['proion'];

    $resultTask = mysqli_query($con, "SELECT username_res, citizen_name  FROM tasks WHERE destination_lat='$latitude' AND destination_lng='$longitude' AND proion='$proion'");
    $rows = array();
    if(mysqli_num_rows($resultTask)>0){
        while($rowTask = mysqli_fetch_array($resultTask)){
            $rows[] = $rowTask;
            }
            echo json_encode($rows);
        }
    else{
        echo json_encode(array('message' => 'No task has been taken'));
    }
?>