<?php 
   session_start();

   include("php/config.php");

   if(!isset($_SESSION['username'])){
    header("Location: index.php");
   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css"/>
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
     
    <style>
    .box{justify-content: center; align-items: center;}
    .menu {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 10px;
    }

    .btn {
        padding: 5px 10px;
        font-size: 16px;
    }
    </style>
    <link rel="stylesheet" href="style/style.css">

    
    <title>Menu</title>
</head>
<body>
    <div class="nav">
        <div class="logo">
            <p>Menu Διαχειριστή</p>
        </div>

        <div class="right-links">
            <?php

            $username = $_SESSION['username'];
            $query = mysqli_query($con,"SELECT*FROM users WHERE username='$username'");

            while($result = mysqli_fetch_assoc($query)){
                $res_uname = $result['username'];
                $res_name = $result['name'];
                
            }
            
            
            ?>
        

            <a href="php/logout.php"> <button class="btn">Log Out</button> </a>

        </div>
    </div>
    
    <main>
       <div class="main-box top">
          <div class="top">
            <div class="box">
                <p>Name: <b><?php echo $res_name ?></b>, username: <b><?php echo $res_uname ?></b></p>
            </div>
            <hr>
            <div class="menu">
            <hr><a href="adminHome.php"><button class="btn">Αποθήκη</button></a><hr>
                    <a href="adminMap.php"><button class="btn">Χάρτης</button></a><hr>
                    <a href="adminCrRescAcc.php"><button class="btn">Δημ. Λογ. Διασώστη</button></a><hr>
                    <a href="adminStatistics.php"><button class="btn">Στατιστικά</button></a><hr>
                    <a href="adminAnak.php"><button class="btn">Δημ. Ανακοίνωσης</button></a><hr>            
            </div>
            </hr><hr>
            
       </div>
       <hr>
       <hr>
       <br>
       <p><b>Δημιουργία Ανακοινώσεων</b></p>

        <form class="anak_form" action="store_anakoinosi.php" method="post">
                <div class="field input">
                    <label for="bigText">Γράψτε μια ανακοίνωση:</label><br>
                    <textarea id="bigText" name="bigText" rows="15" cols="50" required></textarea>
                    <br>
                </div>
            
                <div class="field">
                    
                    <input type="submit" class="btn" name="submit" value="Υποβολή" required>
                </div>
        </form> 
              
    </main>
</body>
</html>