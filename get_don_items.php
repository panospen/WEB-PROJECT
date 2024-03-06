<?php
    include("php/config.php");
    if($_POST['cat_id']){
        $item_sel = "SELECT * from products WHERE category =".$_POST['cat_id'];
        $item_cat_sel = mysqli_query($con, $item_sel);

        if (mysqli_num_rows($item_cat_sel) > 0){
            while($items = mysqli_fetch_assoc($item_cat_sel)){
                echo '<option>'.$items['pr_name'].'</option>';
            }
        }
        else{
            echo '<option>No items found</option>';
        }
    }
?>