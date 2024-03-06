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
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
     
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
       <h2>Statistics Pie Chart</h2> 
       <div class="chart-container">
          <label for="dateRange">Select Time Period:</label>
          <input type="date" id="startDate">
          <input type="date" id="endDate">
          <br>
          <button type="button" class="btn" onclick="updateChart()">Update Chart</button>
          <br>
          <div class="pie-chart-container">
            <canvas id="pie-chart" width = "400" height = "400"></canvas>
          </div>
          <div class="pie-chart-container2">
            <canvas id="pie-chart2" width = "400" height = "400"></canvas>
          </div>
          <style>
            div[class="chart-container"]{width: 80%; height:480px;}
            div[class="pie-chart-container"]{width: 360px; height:360px; float:left;}
            div[class="pie-chart-container2"]{width: 360px; height:360px; float:right;}
          </style>
       </div>
       
    </main>
    
    <script>
     function updateChart() {
      $(document).ready(function () {
        var start_date = document.getElementById("startDate").value;
        var end_date = document.getElementById("endDate").value;
        $.ajax({
                type: 'post',
                url: 'chart.php',
                data: {startDate : start_date, endDate : end_date},
                success: function (data) {
    console.log('Data from server:', data);

    if (data.error) {
        console.error("Error fetching data:", data.error);
        return;
    }

    

    
    var newRequests = data.newRequests;
    var processedRequests = data.processedRequests;

    // Access the canvas and context
    var ctx = document.getElementById('pie-chart').getContext('2d');

    // Destroy the existing chart if it exists
    if (window.myPieChart) {
        window.myPieChart.destroy();
    }

    // Create a new pie chart
    window.myPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['New Requests', 'Processed Requests'],
            datasets: [{
                data: [data.newRequests.reduce((a, b) => a + b, 0), data.processedRequests.reduce((a, b) => a + b, 0)],
                backgroundColor: ['rgb(255, 99, 132)', 'rgb(54, 162, 235)'],
            }],
        },
        options: {
            title: {
                display: true,
                text: 'Requests Overview'
            },
        },
    });
},
                error: function (error) {
                    console.error("Error fetching data:", error);
                }
            });

            $.ajax({
                type: 'post',
                url: 'chartDon.php',
                data: {startDate : start_date, endDate : end_date},
                success: function (data) {
    console.log('Data from server:', data);

    if (data.error) {
        console.error("Error fetching data:", data.error);
        return;
    }

    var newDonations = data.newDonations;
    var processedDonations = data.processedDonations;

    // Access the canvas and context
    var ctx2 = document.getElementById('pie-chart2').getContext('2d');

    // Destroy the existing chart if it exists
    if (window.myPieChart2) {
        window.myPieChart2.destroy();
    }

    // Create a new pie chart
    window.myPieChart2 = new Chart(ctx2, {
        type: 'pie',
        data: {
            labels: ['New Donations', 'Processed Donations'],
            datasets: [{
                data: [data.newDonations.reduce((a, b) => a + b, 0), data.processedDonations.reduce((a, b) => a + b, 0)],
                backgroundColor: ['rgb(255, 99, 132)', 'rgb(54, 162, 235)'],
            }],
        },
        options: {
            title: {
                display: true,
                text: 'Donations Overview'
            },
        },
    });
},
                error: function (error) {
                    console.error("Error fetching data:", error);
                }
            });
      });
     }
        
    </script>
</body>
</html>  
