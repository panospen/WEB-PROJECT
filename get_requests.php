<?php
include("php/config.php");

$result2 = mysqli_query($con,"SELECT * FROM aithmatapolith WHERE username='$res_uname'");
$row2 = mysqli_fetch_assoc($result2);
echo $row2;
?>