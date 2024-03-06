<?php

    include("php/config.php");
    
    $donation = mysqli_query($con, "SELECT username, onoma, mobile, proion, atoma, egine_dekto, hmerominia_doreas, latitude, longitude, donStatus FROM dorees ORDER BY username");
    $rows = array();
    if(mysqli_num_rows($donation)>0){
        while($row_don = mysqli_fetch_array($donation)){
                if($row_don['donStatus'] == "" ){
                    $rows[$row_don['username']][] = $row_don;
                }
            }
            echo json_encode($rows);
        }
    else{
        echo "Δεν υπάρχουν δωρεές";
    }


?>