<?php
    session_start();
    include("php/config.php");
    $catId = $_POST['categoryId'];
    $catName = $_POST['categoryName'];

    mysqli_query($con, "INSERT INTO categories(cat_id, cat_name) VALUES ('$catId','$catName')");
?>