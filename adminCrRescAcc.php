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
       <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
       

       <hr>
       <hr>
       <br>     
       <p><b>Δημιουργία Accounts Διασωστών</b></p>

       <form class="reg_form" action="register_diasostis.php" method="post">
                <div class="field input">
                    <label for="username">Username:</label>
                    <input type="text" name="username" id="username" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="name">Name:</label>
                    <input type="text" name="name" id="name" autocomplete="off" required><br>
                </div>

                <div class="field input">
                    <label for="mobile">Number:</label>
                    <input type="text" name="mobile" id="mobile" autocomplete="off" required><br>
                </div>

                <div class="field input">
                    <label for="mobile">Ανάθεση Οχήματος:(id)</label>
                    <input type="text" name="car_dist" id="car_dist" autocomplete="off" required><br>
                </div>

                <div class="field input">
                    <label for="username">Latitude:</label>
                    <input type="text" name="latitude" id="latitude" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="longitude">Longitude:</label>
                    <input type="text" name="longitude" id="longitude" autocomplete="off" required>
                </div>
            
                <div class="field">
                    
                    <input type="submit" class="btn" name="submit" value="Register" required>
                </div>
            </form>

        
              
    </main>

    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    
    <script>


    </script>
</body>
</html>