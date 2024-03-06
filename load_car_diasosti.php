<?php
    session_start();
    include("php/config.php");
    $car_id = $_SESSION['carid'];
    $result = mysqli_query($con, "SELECT username, latitude, longitude FROM oxhmata WHERE username = '$car_id'");
    $rows = array();
    if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_array($result)){
            $rows[] = $row;
            }
            echo json_encode($rows);
        }
    else{
        echo "Δεν υπάρχουν ανακοινώσεις";
    }
?>