<?php
    session_start();

    include("php/config.php");
    $username = $_SESSION['username'];

    $result_don = mysqli_query($con, "SELECT donId, proion, atoma, egine_dekto, hmerominia_doreas, hmerominia_oloklirosis FROM dorees WHERE username = '$username'");
    $rows = array();
    if(mysqli_num_rows($result_don)>0){
        while($row_don = mysqli_fetch_array($result_don)){
            $rows[] = $row_don;
            }
            echo json_encode($rows);
        }
    else{
        echo "Δεν υπάρχουν δωρεές";
    }


?>