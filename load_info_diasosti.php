<?php
    session_start();
    include("php/config.php");
    $username = $_SESSION['name'];
    $result = mysqli_query($con, "SELECT latitude, longitude FROM users WHERE username = '$username'");
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