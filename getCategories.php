<?php
    include("php/config.php");
    $aithma = mysqli_query($con, "SELECT cat_id, cat_name FROM categories");
    $rows = array();
    if(mysqli_num_rows($aithma)>0){
        while($rows_cat = mysqli_fetch_array($aithma)){
            $rows[] = $rows_cat;
            }
            echo json_encode($rows);
        }
    else{
        echo "Δεν υπάρχουν αιτήματα";
    }
?>