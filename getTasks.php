<?php
    session_start();
    include("php/config.php");
    $username = $_SESSION['username'];
    $result_task = mysqli_query($con, "SELECT id_task, eidos_task, citizen_name, citizen_mobile, proion, atoma, hmerominia_analipsis, task_status  FROM tasks WHERE username_res = '$username'");
    $rows = array();
    if(mysqli_num_rows($result_task)>0){
        while($row_task = mysqli_fetch_array($result_task)){
            if($row_task['task_status'] == ''){
                $rows[] = $row_task;
            }
            }
            echo json_encode($rows);
        }
    else{
        echo json_encode(array('message' => 'Δεν υπάρχουν Tasks'));
    }
?>