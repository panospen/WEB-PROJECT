<?php 
   session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Login</title>
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

    #container {
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
      <div class="container">
        <div class="box form-box">
            <?php 
             
              include("php/config.php");
              if(isset($_POST['submit'])){
                $username = mysqli_real_escape_string($con,$_POST['username']);
                $password = mysqli_real_escape_string($con,$_POST['password']);

                $result = mysqli_query($con,"SELECT * FROM users WHERE username='$username' AND password='$password' ") or die("Select Error");
                $row = mysqli_fetch_assoc($result);

                if(is_array($row) && !empty($row)){
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['password'] = $row['password'];
                    
                }else{
                    echo "<div class='message'>
                      <p>Wrong Username or Password</p>
                       </div> <br>";
                   echo "<a href='index.php'><button class='btn'>Go Back</button>";
         
                }
                if(isset($_SESSION['username'])){
                    if($row['id'] == 'citizen'){
                        header("Location: citizenRequest.php");
                    }
                    elseif($row['id'] == 'admin'){
                        header("Location: adminHome.php");
                    }
                    else{
                        header("Location: diasostisHome.php");
                    }
                        
                }
              }else{

            
            ?>
            
            <header>Login</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>

                <div class="field">
                    
                    <input type="submit" class="btn" name="submit" value="Login" required>
                </div>
                <div class="links">
                    Don't have account? <a href="register.php">Sign Up Now</a>
                </div>
            </form>
        </div>
        <?php } ?>
      </div>
    
</body>
</html>