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
    
    table{
        width: 900px;
        font-family: sans-serif;
        font-weight: 100;
        border-collapse: collapse;
        overflow: hidden;
        box-shadow: 0 0 20px #0000001a;
    }

    th{
        text-align: left;
    }

    thead th{
        background-color: #4c44c7;
    }

    tbody tr:hover {
        background-color: #ffffff4d;
    }

    tbody td{
        position: relative;
    }

    tbody td:hover:before {
        content: "";
        position: absolute;
        background-color: #ffffff33;
        left: 0;
        right: 0;
        top: -9999px;
        bottom: -9999px;
        z-index: -1;
    }
    
    </style>
    <link rel="stylesheet" href="style/style.css">
    <title>Menu Πολίτη</title>
    
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    
</head>
<body>
    <div class="nav">
        <div class="logo">
            <p>Menu Πολίτη</p>
        </div>

        <div class="right-links">

            <?php 
            
            $username = $_SESSION['username'];
            $query = mysqli_query($con,"SELECT*FROM users WHERE username='$username'");

            while($result = mysqli_fetch_assoc($query)){
                $res_uname = $result['username'];
                $res_name = $result['name'];
                
            }
            
            $_SESSION['username'] = $res_uname;
            ?>

            <a href="php/logout.php"> <button class="btn">Log Out</button> </a>

        </div>
    </div>
    <main>

       <div class="main-box top">
         <?php
            include("php/config.php");

            $res = mysqli_query($con,"SELECT name, mobile, latitude, longitude FROM users WHERE username = '$res_uname'");
            while($result = mysqli_fetch_assoc($res)){
                $name = $result['name'];
                $mobile = $result['mobile'];
                $latitude = $result['latitude'];
                $longitude = $result['longitude'];
                
            }
            if(isset($_POST['submit'])){
                $category = $_POST['category'];
                
                switch($category){
          
                    case "1":
                        $category = 'Beverages';
                        break;    
                
                    case "2":
                        $category = 'Cleaning Supplies';
                        break; 
                    case "3":
                        $category = 'Clothing';
                        break; 
                    case "4":
                        $category = 'First Aid';
                        break; 
                    case "5":
                        $category = 'Food';
                        break; 
                    case "6":
                        $category = 'Kitchen Supplies';
                        break; 
                    case "7":
                        $category = 'Medical Supplies';
                        break;
                    case "8":
                        $category = 'Personal Hygiene';
                        break;
                    case "9":
                        $category = 'Shoes';
                        break;             
                }
                
                $product = $_POST['item'];
                $quantity = $_POST['quantity'];

                $rec = mysqli_query($con, "INSERT INTO doreespolith(username,  eidos, proion, atoma) VALUES('$res_uname', '$category', '$product', '$quantity')");
                mysqli_query($con, "INSERT INTO dorees(username, onoma, mobile, eidos, proion, atoma, egine_dekto, hmerominia_aitisis, hmerominia_oloklirosis, latitude, longitude ) VALUES('$res_uname',  '$name', '$mobile', '$category', '$product', '$quantity', ' ', current_timestamp(), ' ', '$latitude', '$longitude')");
                
                if(!$rec){
                    echo "<div class='message'>
                    <p>Error kata thn eggrafi</p>
                    </div> <br>";    
                }
            }

        ?>
        <div class="top">
            <div class="box">
                <p>Hello <b><?php echo $res_name ?></b>, Welcome with username <b><?php echo $res_uname ?></b></p>
            </div>
            <hr>
            <div class="menu">
                <hr>
                <a href = "citizenRequest.php"><button class = "btn">ΔΗΜΙΟΥΡΓΙΑ ΑΙΤΗΜΑΤΟΣ</button></a><hr><a href = "citizenDonation.php"><button class = "btn">ΔΗΜΙΟΥΡΓΙΑ ΔΩΡΕΑΣ</button></a><hr><a href = "citizenNea.php"><button class = "btn">ΝΕΑ</button></a> 
                </hr>
          </div>
          <hr>
          </div>
          <hr><hr>
          <br>
          <div class="anakoinoseis">
            <br><h2><b>ΑΝΑΚΟΙΝΩΣΕΙΣ</b></h2>
            <table border="1" id="table" class="table table-striped">
                <thead>
                    <tr>
                        <th>Ανακοίνωση: </th>
                        <th>Ημερομηνία Δημοσίευσης: </th>
                        <th>Θέλω να κάνω δωρεά!</th>
                    </tr>
                </thead>
                <tbody id ="data">

                </tbody>
            </table>

         
            <style>
                button[class=btnmore]{
                    width: 230px;
                    height: 35px;
                    background: rgba(76,68,182,0.808);
                    border: 0;
                    border-radius: 5px;
                    color: #fff;
                    font-size: 15px;
                    cursor: pointer;
                    transition: all .3s;
                    margin-top: 10px;
                    padding: 0px 10px;
                }
            </style>     
        
        </div>  
        
    </main>
    </body> 
    
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>            

    <script type="text/javascript">
        var ajax = new XMLHttpRequest();
        var method = "GET";
        var url = "load_anakoinosi.php";
        var asynchronous = true;

        ajax.open(method, url, asynchronous);

        ajax.send();

        ajax.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var data = JSON.parse(this.responseText);
                
                var html = "";
                for (var i = 0; i < data.length; i++) {
                    var id_anak = data[i].id_anak;
                    var keimeno = data[i].keimeno;
                    var hmerominia_dimosieusis = data[i].hmerominia_dimosieusis;

                    html += "<tr>";
                        html += "<td>" + keimeno + "</td>";
                        html += "<td>" + hmerominia_dimosieusis + "</td>";
                        html += "<td><a href='dorea.php?id_anak=" + id_anak + "'><button class='btn'>Δωρεά!</button></td>";
                    html += "</tr>";
                }
                document.getElementById("data").innerHTML = html;
            }
        }
    </script>

</html>