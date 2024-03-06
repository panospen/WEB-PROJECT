<?php
    session_start();

    include("php/config.php");
    $username = $_SESSION['username'];

    $result_ait = mysqli_query($con, "SELECT eidos, proion, atoma, egine_dekto, hmerominia_aitisis, hmerominia_oloklirosis FROM aithmata WHERE username = '$username'");
    $rows = array();
    if(mysqli_num_rows($result_ait)>0){
        while($row_ait = mysqli_fetch_array($result_ait)){
            $rows[] = $row_ait;
            }
            echo json_encode($rows);
        }
    else{
        echo "Δεν υπάρχουν αιτήματα";
    }


?>