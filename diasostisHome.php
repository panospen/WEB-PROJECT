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
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin="">
     </script>
     <script src = "https://code.jquery.com/jquery-3.6.4.min.js"></script>
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
    <title>Menu Διασώστη</title>
</head>
<body>
    <div class="nav">
        <div class="logo">
            <p>Menu Διασώστη</p>
        </div>

        <div class="right-links">
            <?php
                $username = $_SESSION['username'];
                $query = mysqli_query($con,"SELECT*FROM users WHERE username='$username'");
                $queryy = mysqli_query($con,"SELECT*FROM diasostes WHERE username='$username'");

                while($result = mysqli_fetch_assoc($query)){
                    $res_usname = $result['username'];
                    $res_name = $result['name'];
    
                }
        

                while($result = mysqli_fetch_assoc($queryy)){
                    $car_id = $result['car_id'];
    
                }
                $_SESSION['name'] = $res_usname;
                $_SESSION['carid'] = $car_id;  
            ?>
            
            <a href="php/logout.php"> <button class="btn">Log Out</button> </a>

        </div>
    </div>
    <main>

        <div class="main-box top">
           <div class="top">
             <div class="box">
                 <p>Hello <b><?php echo $res_name ?></b>, Welcome with username <b><?php echo $res_usname ?></b>. Your car id is <b><?php echo $car_id?></b></p>
                 <input type="hidden" id="carId" value="<?php echo htmlspecialchars($car_id); ?>">
             </div>
             <hr>
             <div class="menu">
              <hr>
                <a href = "diasostisHome.php"><button class = "btn">Αρχική</button></a><hr><a href = "diasostisMap.php"><button class = "btn">Χάρτης</button></a> 
              </hr>
              <hr></hr>
             </div>
             <hr>
           </div>
           <hr>
           <hr>
           <br><br>
           <p><b>Διαχείριση Φορτίου</b></p>

           <form method="POST" id="moveItemForm" name="moveItemForm">

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

            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" required>
        </form>
<style>
#moveItemForm {
background-color: #fff;
padding: 20px;
border-radius: 8px;
box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
max-width: 400px;
margin: 0;
}

#moveItemForm label {
display: block;
margin-bottom: 8px;
}

#moveItemForm select,
#moveItemForm input {
width: 100%;
padding: 10px;
margin-bottom: 15px;
box-sizing: border-box;
border: 1px solid #ccc;
border-radius: 4px;
font-size: 1em;
}

#moveItemForm button {
background-color: #4caf50;
color: #fff;
padding: 10px 15px;
border: none;
border-radius: 4px;
cursor: pointer;
font-size: 1em;
}



#moveItemForm button:hover {
background-color: #45a049;
}
</style>
<table id="inventoryTable" class="custom-table" >
<thead>
<tr>
<th style="width: 30%;">Load ID</th>
<th style="width: 40%;">Product Name</th>
<th style="width: 30%;">Category</th>
<th style="width: 30%;">Quantity</th>
</tr>
</thead>
<tbody id="inventoryBody"></tbody>
</table>
<style>

.custom-table {
width: 60%;
margin-top: 10px;
margin-left: 50px; 
border-collapse: collapse;
border: 1px solid #ddd;
}

.custom-table th, .custom-table td {
padding: 8px;
text-align: left;
border-bottom: 1px solid #ddd;
}

.custom-table th {
background-color: #f2f2f2;
}

.custom-table tbody tr:hover {
background-color: #f5f5f5;
}
</style>

<button id="btnfortiou">Εμφάνιση Φορτίου</button>
<style>
button[id=btnfortiou]{
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

<button id="btnfortosis" >Φόρτωση</button>
<style>
button[id=btnfortosis]{
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

<button id="btnekfortosis" onclick="promptForLoadId()">Εκφόρτωση</button>
<style>
button[id=btnekfortosis]{
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

<table id="inventoryTable">
        
     </main>
     
     <script>

function promptForLoadId() {
    var loadId = prompt("Enter the Load ID you want to move to the inventory:");

    if (loadId !== null && loadId !== "") {
        // User provided a load_id
        moveRecordToInventory(loadId);
    } else {
        // User canceled or entered an empty value
        alert("Operation canceled.");
    }
}

function moveRecordToInventory(loadId) {
    // Make an AJAX request to move the record to the inventory
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "unloadItem.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var data = "loadId=" + loadId;

    // Send the request
    xhr.send(data);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            
            try {
                var response = JSON.parse(xhr.responseText);
                console.log(response);
            } catch (e) {
                console.error("Error parsing JSON:", e);
            }
        } else {
            console.error("HTTP request failed with status:", xhr.status);
            console.log(xhr.responseText); // Log the HTML error page
        }
        }
    }

 var carId = document.getElementById("carId").value;

document.addEventListener("DOMContentLoaded", function () {
   
    // Attach a click event to the button
    document.getElementById("btnfortosis").addEventListener("click", function () {
        // Get user input or selected values
        var prName = document.getElementById("item").value;
        var category = document.getElementById("category").value;
        var quantity = document.getElementById("quantity").value;

        switch(category){
          
          case 1:
              category = 'Beverages';
              break;    
      
          case 2:
              category = 'Cleaning Supplies';
              break; 
          case 3:
              category = 'Clothing';
              break; 
          case 4:
              category = 'First Aid';
              break; 
          case 5:
              category = 'Food';
              break; 
          case 6:
              category = 'Kitchen Supplies';
              break; 
          case 7:
              category = 'Medical Supplies';
              break;
          case 8:
              category = 'Personal Hygiene';
              break;
          case 9:
              category = 'Shoes';
              break;             
      }

        // Create an object to hold the data
        var data = {
            car_id: carId, 
            pr_name: prName,
            category: category,
            quantity: quantity
        };

        // Make a Fetch API request to the server to insert the record
        fetch("moveItem.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);

            // If the record was added successfully, clear input fields
            if (data.message === "Record added successfully") {
                document.getElementById("prNameInput").value = "";
                document.getElementById("categoryInput").value = "";
                document.getElementById("quantityInput").value = "";
            }
        })
        .catch(error => {
            console.error(error);
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    var categoryMapping = {
        1: "Beverages",
        2: "Cleaning Supplies",
        3: "Clothing",
        4: "First Aid",
        5: "Food",
        6: "Kitchen Supplies",
        7: "Medical Supplies", 
        8:  "Personal Hygiene",
        9: "Shoes"      
    };
    // Attach a click event to the button
    document.getElementById("btnfortiou").addEventListener("click", function () {
        toggleInventoryVisibility();

    });
    function toggleInventoryVisibility() {
        var table = document.getElementById("inventoryTable");
        var isVisible = table.style.display === "table";

        // If the table is visible, hide it; otherwise, show it
        table.style.display = isVisible ? "none" : "table";

        // If the table is now visible, fetch and display the inventory
        if (!isVisible) {
            displayInventory();
        }
    }
    // Function to display the inventory
    function displayInventory() {
        // Make a Fetch API request to the server to get the inventory
        fetch("get_inventory.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                car_id: carId 
            })
        })
        .then(response => response.json())
        .then(data => {
            // Handle the server's response and update the table
            updateInventoryTable(data);
        })
        .catch(error => {
            console.error(error);
        });
    }

    // Function to update the inventory table
    function updateInventoryTable(inventoryData) {
        var tableBody = document.getElementById("inventoryBody");

        // Clear existing table rows
        tableBody.innerHTML = "";

        // Populate the table with inventory data
        inventoryData.forEach(function (item) {
            var row = tableBody.insertRow();
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);

            cell1.textContent = item.load_id;
            cell2.textContent = item.pr_name;
            cell3.textContent = categoryMapping[item.category];
            cell4.textContent = item.quantity;
        });
    }
});
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

    </script>
</body>
</html>