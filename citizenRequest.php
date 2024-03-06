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
        width: 800px;
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

                $rec = mysqli_query($con, "INSERT INTO aithmatapolith(username,  eidos, proion, atoma) VALUES('$res_uname', '$category', '$product', '$quantity')");
                mysqli_query($con, "INSERT INTO aithmata(username, onoma, mobile, eidos, proion, atoma, egine_dekto, hmerominia_aitisis, hmerominia_oloklirosis, latitude, longitude ) VALUES('$res_uname',  '$name', '$mobile', '$category', '$product', '$quantity', ' ', current_timestamp(), ' ', '$latitude', '$longitude')");
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
            <hr></hr>
          </div>
          <hr>
          </div>
          <hr><hr>
          <br><br><p><b>ΔΗΜΙΟΥΡΓΙΑ ΑΙΤΗΜΑΤΟΣ</b></p>
            <form method="POST"  id="requestForm" name="requestForm">

                <?php
                  $get_cat = "SELECT * FROM categories";
                  $result_get = mysqli_query($con, $get_cat);
                ?>

                <label for="categories" id="categories" name="categories">Κατηγορία:</label>
                <select id="category" name="category" onchange = "getItems(this.value)">
                         <option value="">Select</option>
                        <?php
                             if(mysqli_num_rows($result_get)>0){
                                while($result_cat = mysqli_fetch_assoc($result_get)){
                                    echo '<option value = '.$result_cat['cat_id'].'>'.$result_cat['cat_name'].'</option>';
                                }
                             }
                             
                        ?>       
                    
                </select>
                <br>

                <label for="items" id="items" name="items">Προϊόν:</label>
                <select id="item" name="item">
                            <option value="">Select Product</option>
                </select>
                <br>

                <label for="quantity">Πλήθος ατόμων:</label>
                <input type="number" id="quantity" name="quantity"><br>
                <input type="button" name="add" value="Add Request" onclick="addRequest();" class="btn"><br>

              <input type="submit" class="btn" name="submit" value="Υποβολή">

            </form>
            <br>
            <hr><hr>
            <br>
            <div class = "aithmata">
              <h2>Τα αιτήματά μου</h2>
              <table border="1" id="reqtable" class="reqtable">
                    <thead>
                        <tr>
                            <th>Κατηγορία </th>
                            <th>Είδος </th> 
                            <th>Άτομα </th> 
                            <th>Έγινε δεκτό </th> 
                            <th>Ημερομηνία Αίτησης </th> 
                            <th>Ημερομηνία Ολοκλήρωσης </th> 
                        </tr>
                    </thead>
                    <tbody id="requests">

                    </tbody>
               </table> 
            </div> 
        
    </main>
    </body> 
    
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>            

    <script type="text/javascript">
        function getItems(id){
            $('#item').html('');
            $.ajax({
                type: 'post',
                url: 'get_items_citizen.php',
                data: {cat_id : id},
                success : function(data){
                    $('#item').html(data);
                }
            })
            
        }

        function addRequest(){
        
        var category = document.requestForm.category.value;
        var quantity = document.requestForm.quantity.value;

        var tr= document.createElement('tr');

        var td1 = tr.appendChild(document.createElement('td'));
        var td2 = tr.appendChild(document.createElement('td'));

        td1.innerHTML='<label for="category">Κατηγορία:</label><select id="category" name="category" required><option value="water">Νερό</option><option value="water">Φαγητό</option><option value="water">Ιατρική Βοήθεια</option> <option value="water">Ρούχα</option> <option value="water">Παπούτσια</option> </select><br><label for="quantity">Πλήθος ατόμων:</label><input type="number" id="quantity" name="quantity"required><br>';

        document.getElementById("requestForm").appendChild(tr);
    }

    var xhr = new XMLHttpRequest();
        var method = "GET";
        var url = "load_aithmata.php";
        var asynchronous = true;

        xhr.open(method, url, asynchronous);

        xhr.send();

        xhr.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var ait = JSON.parse(this.responseText);
                
                var htm = "";
                for (var i = 0; i < ait.length; i++) {
                    var eidos = ait[i].eidos;
                    var proion = ait[i].proion;
                    var atoma = ait[i].atoma;
                    var egine_dekto = ait[i].egine_dekto;
                    var hmerominia_aitisis = ait[i].hmerominia_aitisis;
                    var hmerominia_oloklirosis = ait[i].hmerominia_oloklirosis;

                    htm += "<tr>";
                        htm += "<td>" + eidos + "</td>";
                        htm += "<td>" + proion + "</td>";
                        htm += "<td>" + atoma + "</td>";
                        htm += "<td>" + egine_dekto + "</td>";
                        htm += "<td>" + hmerominia_aitisis + "</td>";
                        htm += "<td>" + hmerominia_oloklirosis + "</td>";
                    htm += "</tr>";
                }
                document.getElementById("requests").innerHTML = htm;
            }
        }
    </script>

</html>