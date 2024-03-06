<?php 
   session_start();

   include("php/config.php");
   //include("jsontomysql.php");

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
         #map {position: center; height: 400px; padding-left: 200px; padding-right: 500px; padding-top: 500px; max-width: 500px;}
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
                <p>Hello <b><?php echo $res_name ?></b>, Welcome with username <b><?php echo $res_uname ?></b>.</p>
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
       
       <h2><b>Διαχείρηση Αποθήκης Βάσης</b></h2>
       <hr> 
       <h3>Add/Edit Category</h3>
       <form action="process_category.php" method="post">
    <label for="categoryId">Category ID:</label>
    <input type="text" id="categoryId" name="categoryId" required>
    <br>
    <label for="categoryName">Category Name:</label>
    <input type="text" id="categoryName" name="categoryName" required>
    <br>
    <input type="radio" name="categoryAction" value="add" checked> Add Category
    <input type="radio" name="categoryAction" value="edit"> Edit Category
     <br>       
    <button class="btn" type="submit">Submit Category</button>
</form>
<hr>
<!-- Item Form -->
<h3>Add/Edit Item</h3>
<form action="process_category.php" method="post">
    <label for="itemId">Item ID:</label>
    <input type="text" id="itemId" name="itemId" required>
  
    <label for="itemName">Item Name:</label>
    <input type="text" id="itemName" name="itemName" required>
    
    <label for="categorySel">Select Category:</label>
    <select id="categorySel" name="categorySel"></select>
    <br>
    <label for="detailName">Detail Name:</label>
    <input type="text" id="detailName" name="detailName" required>
    
    <label for="detailValue">Detail Value:</label>
    <input type="text" id="detailValue" name="detailValue" required>
    <br>
    <input type="radio" name="itemAction" value="add" checked> Add Item
    <input type="radio" name="itemAction" value="edit"> Edit Item
    <br>
    <button class="btn" type="submit">Submit Item</button>
</form>
       <hr>
       <br>
       <div id="uploadJSON">
          <!-- Upload JSON Form -->
          <h3>Upload JSON File</h3>
          <form id="jsonUploadForm">
              <label for="jsonFile">Select JSON File:</label>
              <input type="file" id="jsonFile" name="jsonFile" accept=".json">
              <br>
              <button class="btn" type="submit">Upload JSON</button>
          </form>
       </div>

       <hr><hr>
       <br>

       <div>
          <h3>Items in DB</h3>  
          <form>
              <label for="category">Select Category:</label>
              <select id="category" name="category"></select>
          </form>
      
          <table border = "1" id="productTable">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Details</th>
              </tr>
            </thead>
            <tbody id="productTableBody">
            </tbody>
          </table>
        </div>  

       <hr>
       <hr>
       <hr>
       <br>
         <span id="alert_mes"></span>
         <div class="col-lg-10 col-sm-8">   
            <div class="row">
                <h2 class="title">Κατάσταση Αποθήκης</h2>
            </div>
            <hr>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
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
                        <table border = "1" class="table table-bordered" id="itemtable">
                            <thead> 
                            </thead>
                            <tbody id="ans">
                                
                            </tbody>        
                        </table>
                    </div>
                </div>
            </div>
        </div>
              
    </main>
    
</body>
  <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    
  <script>
    $(document).ready(function() {

      fetchCategories();
          
          // Add event listener to category dropdown
          document.getElementById('category').addEventListener('change', function () {
            var categoryId = this.value;
            fetchProducts(categoryId);
          });


    $("#jsonUploadForm").submit(function(event) {
      event.preventDefault();

      var fileInput = document.getElementById('jsonFile');
      var file = fileInput.files[0];

      if (!file) {
        alert("Please select a file.");
        return;
      }

      var reader = new FileReader();

      reader.onload = function(e) {
        try {
          var jsonData = JSON.parse(e.target.result);

          // Check if the structure matches the requirements
          if (isValidStructure(jsonData)) {
            alert("JSON structure is valid!");
          } else {
            alert("Invalid JSON structure. Please upload a valid JSON file.");
          }
        } catch (error) {
          alert("Error parsing JSON: " + error.message);
        }
      };

      reader.readAsText(file);
    });

    function isValidStructure(jsonData) {
      if (!Array.isArray(jsonData) || jsonData.length === 0) {
    return false;
  }

  // Check if each item in the array has the required properties
  for (var i = 0; i < jsonData.length; i++) {
    var item = jsonData[i];

    if (
      !("id" in item) ||
      typeof item.id !== "string" ||
      (!("category_name" in item) && !("name" in item)) ||
      (item.details && !Array.isArray(item.details))
    ) {
      return false;
    }

    // Check details if present
    if (item.details) {
      for (var j = 0; j < item.details.length; j++) {
        var detail = item.details[j];

        if (
          !("detail_name" in detail) ||
          !("detail_value" in detail) ||
          typeof detail.detail_name !== "string" ||
          typeof detail.detail_value !== "string"
        ) {
          return false;
        }
      }
    }
  }

  return true;
    }
  });

  document.addEventListener('DOMContentLoaded', function () {
        const categoryForm = document.getElementById('categoryForm');
        const itemForm = document.getElementById('itemForm');

        categoryForm.addEventListener('submit', function (event) {
            event.preventDefault();
            submitForm(categoryForm);
        });

        itemForm.addEventListener('submit', function (event) {
            event.preventDefault();
            submitForm(itemForm);
        });

        function submitForm(form) {
            const formData = new FormData(form);
            fetch(form.action, {
                method: 'POST',
                body: formData
            }).then(response => {
                if (response.ok) {
                    
                    console.log('Form submitted successfully');
                } else {
                  
                    console.error('Form submission failed');
                }
            }).catch(error => {
                console.error('Error:', error);
            });
        }
    });

    function fetchCategories() {
      fetch('categories.json') 
      .then(response => response.json())
      .then(categories => {
        var categoryDropdown = document.getElementById('category');
        categoryDropdown.innerHTML = '';

        categories.forEach(category => {
          var option = document.createElement('option');
          option.value = category.id;
          option.text = category.category_name;
          categoryDropdown.add(option);
        });
      })
      .catch(error => console.error('Error fetching categories:', error));
    }

function fetchProducts(categoryId) {
  fetch('items.json') 
    .then(response => response.json())
    .then(items => {
      var productTableBody = document.getElementById('productTableBody');
      productTableBody.innerHTML = ''; // Clear existing rows

      items.forEach(item => {
        if (item.category === categoryId) {
          var row = productTableBody.insertRow();
          row.insertCell(0).textContent = item.id;
          row.insertCell(1).textContent = item.name;

          var detailsCell = row.insertCell(2);
          detailsCell.textContent = ''; // Clear existing content

          item.details.forEach(detail => {
            detailsCell.textContent += detail.detail_name + ': ' + detail.detail_value + ', ';
          });

          // Remove the trailing comma and space
          detailsCell.textContent = detailsCell.textContent.slice(0, -2);
        }
      });
    })
    .catch(error => console.error('Error fetching products:', error));
}

var xhr = new XMLHttpRequest();
        var method = "GET";
        var url = "getCategories.php";
        var asynchronous = true;

        xhr.open(method, url, asynchronous);

        xhr.send();

        xhr.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var cat = JSON.parse(this.responseText);
                
                var htm = "";
                for(var i = 0; i <cat.length; i++) {
                  var catId = cat[i].cat_id;
                  var catName = cat[i].cat_name;

                  htm += "<option value=" + catId + ">" + catName + "</option>"; 
                }
                document.getElementById("categorySel").innerHTML = htm;
            }
        }


function getItems(id){
            $('#ans').html('');
            $.ajax({
                type: 'post',
                url: 'get_items.php',
                data: {cat_id : id},
                success : function(data){
                    $('#ans').html(data);
                }
            })
            
        }
 
    </script>
</body>
</html>