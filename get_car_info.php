<?php
include("php/config.php");

$result_car = mysqli_query($con, "SELECT car_id, pr_name, quantity FROM loads");
$rows = array();

if (mysqli_num_rows($result_car) > 0) {
    while ($row_car = mysqli_fetch_array($result_car)) {
        $rows[] = $row_car;
    }
}

$task_car = mysqli_query($con, "SELECT car_id, eidos_task, username_res, citizen_name, citizen_mobile, proion, atoma FROM tasks");
$rowss = array();

if (mysqli_num_rows($task_car) > 0) {
    while ($row_cars = mysqli_fetch_array($task_car)) {
        $rowss[] = $row_cars;
    }
}

$response = array('loads' => $rows, 'tasks' => $rowss);

echo json_encode($response);
?>