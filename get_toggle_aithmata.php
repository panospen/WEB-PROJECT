<?php
    include("php/config.php");
    $aithma = mysqli_query($con, "SELECT username, onoma, mobile, proion, atoma, egine_dekto, hmerominia_aitisis, latitude, longitude FROM aithmata ORDER BY username");
    $rows = array();
    if(mysqli_num_rows($aithma)>0){
        while($rows_ait = mysqli_fetch_array($aithma)){
            if ($rows_ait['egine_dekto'] === 'ΝΑΙ') {
                $rows[$rows_ait['username']][] = $rows_ait;
            }
            }
            echo json_encode($rows);
        }
    else{
        echo "Δεν υπάρχουν αιτήματα";
    }
?>