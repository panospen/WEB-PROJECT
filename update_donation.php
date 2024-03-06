<?php
    session_start();
    include("php/config.php");

    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $proion = $_POST['proion'];
    $carId = $_POST['carId'];
    $username = $_POST['username'];
    $onoma = $_POST['onoma'];
    $mobile = $_POST['mobile'];
    $atoma = $_POST['atoma'];


    mysqli_query($con,"UPDATE dorees SET egine_dekto ='NAI' WHERE latitude = '$latitude' AND longitude = '$longitude' AND proion = '$proion'") or die("apotuxia");
    mysqli_query($con,"INSERT INTO tasks(eidos_task, username_res, car_id, citizen_name, citizen_mobile, proion, atoma, destination_lat, destination_lng, hmerominia_analipsis, task_status) VALUES ('Donation', '$username', '$carId', '$onoma', '$mobile', '$proion', '$atoma', '$latitude', '$longitude', current_timestamp(), '')");
?>