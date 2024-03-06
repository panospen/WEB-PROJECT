<?php
    session_start();
    include("php/config.php");
    $result_task = mysqli_query($con, "SELECT username_res, car_id, destination_lat, destination_lng  FROM tasks WHERE eidos_task = 'Donation'");
    $rows = array();
    if(mysqli_num_rows($result_task)>0){
        while($row_task = mysqli_fetch_array($result_task)){
            $rows[] = $row_task;
            }
            echo json_encode($rows);
        }
    else{
        echo json_encode(array('message' => 'Δεν υπάρχουν Tasks'));
    }
?>