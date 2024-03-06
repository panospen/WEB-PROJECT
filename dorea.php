<?php
    session_start();
    include("php/config.php");

    $username = $_SESSION['username'];

    if(isset($_GET['id_anak'])){
        $id_anak = $_GET['id_anak'];
    }
    $result_anak = mysqli_query($con, "SELECT keimeno FROM anakoinoseis WHERE id_anak = '$id_anak'");
    while($row_anak = mysqli_fetch_array($result_anak)){
        $keimeno = $row_anak['keimeno'];
    }

    $pattern = '/(?<item>\b(?!and\b)\w+\s?\w*)\bfor\b\s(?<quantity>\d+)\speople/';
    preg_match_all($pattern, $keimeno, $matches, PREG_SET_ORDER);
        foreach($matches as $match){
            $eidos = $match['item'];
            $quantity = $match['quantity'];
        
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
<link rel="stylesheet" href="style/style.css"> 
<style>
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        background: linear-gradient(to left, #8f94fb, #4e54c8);
            width: 100%;
    }

    #content-container {
        text-align: center;
        z-index: 1;
    }

    .area{
        position: fixed;
    top: 0;
    left: 0;
        width: 100%;
        height: 100vh;
        z-index: -1;
    }

    .circles{
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        overflow: hidden;
    }

    li{
        position: absolute;
        display: block;
        background: #ffffff33;
        width: 20px;
        height: 20px;
        list-style: none;
        border-radius: 10%;
    }

    li:nth-child(1){
        left: 25%;
        width: 80px;
        height: 80px;
        animation-delay: 0s;
    }

    li:nth-child(2){
        left: 10%;
        width: 30px;
        height: 30px;
        animation-delay: 2s;
        animation-duration: 12s;
    }

    li:nth-child(3){
        left: 70%;
        width: 30px;
        height: 30px;
        animation-delay: 4s;
    }

    li:nth-child(4){
        left: 40%;
        width: 60px;
        height: 60px;
        animation-delay: 0s;
        animation-duration: 18s;
    }

    li:nth-child(5){
        left: 65%;
        width: 30px;
        height: 30px;
        animation-delay: 0s;
    }

    li:nth-child(6){
        left: 75%;
        width: 110px;
        height: 110px;
        animation-delay: 3s;
    }

    li:nth-child(7){
        left: 35%;
        width: 150px;
        height: 150px;
        animation-delay: 7s;
    }

    li:nth-child(8){
        left: 50%;
        width: 35px;
        height: 35px;
        animation-delay: 15s;
        animation-duration: 45s;
    }

    li:nth-child(9){
        left: 20%;
        width: 25px;
        height: 25px;
        animation-delay: 2s;
        animation-duration: 35s;
    }

    li:nth-child(10){
        left: 85%;
        width: 150px;
        height: 150px;
        animation-delay: 0s;
        animation-duration: 11s;
    }

    li{
        bottom: -150px;
        animation: animate 25s linear infinite;
    }


    @keyframes animate {
    0% {
        transform: translateY(0) rotate(0deg);
        opacity: 1;
        border-radius: 0;
    }

    100% {
        transform: translateY(-1000px) rotate(720deg);
        opacity: 0;
        border-radius: 50%;
    }
}
</style> 

</head>

<body>    
<div class="area">
    <ul class="circles">
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
    </ul>
    </div>
<div class="content-container">
    <p><b>ΔΗΜΙΟΥΡΓΙΑ ΔΩΡΕΑΣ</b></p>
<br>
<?php
    echo '<form method="POST" id="donationForm" name="donationForm">
        <label for="items" id="items" name="items">Προϊόν:</label><br>
        <input type = "text" id="itemsreq" name="itemsreq" value="'. $eidos .' " readonly><br>
        <label for="quantity" id="quantity" name="quantity">Πλήθος ατόμων:</label><br>
        <input type = "text" id="quan" name="quan" value="'. $quantity .'"><br>
        <button type="submit" class="btn" name="submit" >Υποβολή</button>
        </form>';

    }
?>
<?php
    include("php/config.php");
    $res = mysqli_query($con,"SELECT name, mobile, latitude, longitude FROM users WHERE username = '$username'");
    while($result = mysqli_fetch_assoc($res)){
        $name = $result['name'];
        $mobile = $result['mobile'];
        $latitude = $result['latitude'];
        $longitude = $result['longitude'];
        
    }

    if(isset($_POST['submit'])){
        $eidos = $_POST['itemsreq'];
        $quantity = $_POST['quan'];
        $rec = mysqli_query($con, "INSERT INTO doreespolith(username, proion, atoma) VALUES('$username', '$eidos', '$quantity')");
        mysqli_query($con, "INSERT INTO dorees(username, onoma, mobile, proion, atoma, egine_dekto, hmerominia_doreas, hmerominia_oloklirosis, latitude, longitude ) VALUES('$username',  '$name', '$mobile', '$eidos', '$quantity', ' ', current_timestamp(), ' ', '$latitude', '$longitude')");
        if(!$rec){
            echo "<div class='message'>
            <p>Error kata thn eggrafi</p>
            </div> <br>";    
        }
    }
?>

    <a href="citizenNea.php" class = 'btn'>Πίσω</a>
</div>

</body>      

</html>

     

          
        