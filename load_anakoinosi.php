<?php
    session_start();
    include("php/config.php");
    $result_anak = mysqli_query($con, "SELECT id_anak, keimeno, hmerominia_dimosieusis  FROM anakoinoseis");
    $rows = array();
    if(mysqli_num_rows($result_anak)>0){
        while($row_anak = mysqli_fetch_array($result_anak)){
            $rows[] = $row_anak;
            }
            echo json_encode($rows);
        }
    else{
        echo "Δεν υπάρχουν ανακοινώσεις";
    }
?>