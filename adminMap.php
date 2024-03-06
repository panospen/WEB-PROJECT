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
            <hr>
       </div>
       <hr><hr>
       <br>
       <div id="filters" class="filters">
   <label>
      <input type="checkbox" id="filter1"> Taken Requests
   </label>
   <span> | </span>
   <label>
      <input type="checkbox" id="filter2"> Waiting Requests
   </label>
   <span> | </span>
   <label>
      <input type="checkbox" id="filter3"> Only Donations
   </label>
   <span> | </span>
   <label>
      <input type="checkbox" id="filter4"> Cars with tasks
   </label>
   <span> | </span>
   <label>
      <input type="checkbox" id="filter5"> Cars without tasks
   </label>
   <span> | </span>
   <label>
      <input type="checkbox" id="filter6"> Hide Request polylines
   </label>
   <br>
   <label>
      <input type="checkbox" id="filter7"> Hide Donation polylines
   </label>
</div>
       <div align="right" class="map" id="map">Χάρτης</div>

       <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
       <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
       
              
    </main>

    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    
    <script>
        function getMarkerPosition(){
            const savedPosition = localStorage.getItem('markerPosition');
            return savedPosition ? JSON.parse(savedPosition) : [38.246, 21.735];
        }

        function setMarkerPosition(position){
            localStorage.setItem('markerPosition', JSON.stringify(position));
        }
            const initialPosition = getMarkerPosition();

            const map = L.map('map').setView(initialPosition, 13);

            const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            const marker = L.marker(initialPosition, {draggable: true, title:"Βάση"}).addTo(map);

            marker.on('dragend', function(){

                const confirmChange = confirm('Είστε σίγουρος πως θέλετε να αλλάξετε τη θέση του Marker;');

                if(!confirmChange){
                    marker.setLatLng(initialPosition);
                }
            
            });

            marker.on('dragend', function(){
                const newPosition = marker.getLatLng();
                setMarkerPosition([newPosition.lat, newPosition.lng]);
            });

            var carIcon = L.icon({
                iconUrl: 'car-svgrepo-com.svg',
                iconSize: [32, 32],
                iconAnchor: [16, 16],
                popupAnchor: [0, -16]
            });

            var carMarker1 = L.marker([38.280, 21.792], {title:"Όχημα 1 ", icon: carIcon}).addTo(map);
            var carMarker2 = L.marker([38.207, 21.734], {title:"Όχημα 2 ", icon: carIcon}).addTo(map);
            var carMarker3 = L.marker([38.222, 21.775], {title:"Όχημα 3 ", icon: carIcon}).addTo(map);
            

            var ajax = new XMLHttpRequest();
var method = "GET";
var url = "get_car_info.php";
var asynchronous = true;

ajax.open(method, url, asynchronous);

ajax.send();
ajax.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
        var response = JSON.parse(this.responseText);
        var loadsData = response.loads;
        var tasksData = response.tasks;

        switchMarkerData(carMarker1, loadsData, tasksData, "100");
        switchMarkerData(carMarker2, loadsData, tasksData, "200");
        switchMarkerData(carMarker3, loadsData, tasksData, "300");
    }
};

function switchMarkerData(marker, loadsData, tasksData, carId) {
    var load = loadsData.find(load => load.car_id === carId);
    
    if (load) {
        bindPopupWithData(marker, load, tasksData);
    } else {
        // If loadsData is empty
        var popupContent = "<strong>Username:</strong> " + carId +
            "<br><hr>" +
            "<h2>Φορτίο</h2><br>" +
            "Δεν υπάρχει φορτίο στο αυτοκίνητο.";

        // Check if tasksData is empty
        if (!tasksData || tasksData.length === 0) {
            popupContent += "<br><h2>Task Info</h2>" +
                "Δεν υπάρχουν tasks για το αυτοκίνητο.";
        }

        marker.bindPopup(popupContent);
    }
}

function bindPopupWithData(marker, load, tasksData) {
    var popupContent = "<strong>Username:</strong> " + load.car_id +
        "<br><hr><br>" +
        "<h2>Φορτίο</h2>" +
        "Κατηγορία: " + load.category +
        "<br>Προϊόν: " + load.pr_name +
        "<br>Ποσότητα: " + load.quantity;

    var matchingTask = tasksData.find(task => task.car_id === load.car_id);

    if (matchingTask) {
        popupContent += "<hr><br><h2>Task Info</h2>" +
            "Είδος Task: " + matchingTask.eidos_task +
            "<br>Όνομα Πολίτη: " + matchingTask.citizen_name +
            "<br>Τηλέφωνο Πολίτη: " + matchingTask.citizen_mobile +
            "<br>Προϊόν: " + matchingTask.proion +
            "<br>Άτομα: " + matchingTask.atoma;
    }else {
        // If tasksData is empty
        popupContent += "<hr><br><h2>Task Info</h2>" +
            "Δεν υπάρχουν tasks για το αυτοκίνητο.";
    }

    marker.bindPopup(popupContent);
}

       var wait_ait = L.icon({
                iconUrl: 'marker-16.png',
                iconSize: [32, 32],
                iconAnchor: [16, 16],
                popupAnchor: [0, -16]
            });

            var carMarkers = [];
var requestMarkers = [];
var donationMarkers = [];

            var xml = new XMLHttpRequest();
        var method = "GET";
        var url = "get_aithmata.php";
        var asynchronous = true;

        xml.open(method, url, asynchronous);

        xml.send();

        xml.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var ait = JSON.parse(this.responseText);

                for (var username in ait) {
                    var userAithma = ait[username];

                    var popupContent = "";
                    for (var i = 0; i < userAithma.length; i++) {
                        var aithma = userAithma[i];
                        popupContent += "Όνομα: " + aithma.onoma + "<br>Κινητό: " + aithma.mobile + "<br>Προϊόν: " + aithma.proion + "<br>Ποσότητα: " + aithma.atoma + "<br>Ημερομηνία Αίτησης: " + aithma.hmerominia_aitisis + "<br><br>";
                    }
                

                    var latitude = userAithma[0].latitude;
                    var longitude = userAithma[0].longitude;

                    var aithmaMarker = L.marker([latitude, longitude], { title: "Αίτημα", icon: wait_ait, egine_dekto: aithma.egine_dekto}).addTo(map);
                    aithmaMarker.bindPopup("Username: " + username + "<br>" + popupContent);
                    requestMarkers.push(aithmaMarker);
                }
            }
        } 
        
        var wait_don = L.icon({
                iconUrl: 'yellowMarker-16 .png',
                iconSize: [32, 32],
                iconAnchor: [16, 16],
                popupAnchor: [0, -16]
            });

            var don = new XMLHttpRequest();
        var method = "GET";
        var url = "get_dorees.php";
        var asynchronous = true;

        don.open(method, url, asynchronous);

        don.send();

        don.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var donations = JSON.parse(this.responseText);

                    for (var username in donations) {
                    var userDonations = donations[username];

                    var popupContent = "";
                    for (var i = 0; i < userDonations.length; i++) {
                        var donation = userDonations[i];
                        popupContent += "Όνομα: " + donation.onoma + "<br>Κινητό: " + donation.mobile + "<br>Προϊόν: " + donation.proion + "<br>Ποσότητα: " + donation.atoma + "<br>Ημερομηνία Αίτησης: " + donation.hmerominia_doreas + "<br><br>";
                }
                

                    var latitude = userDonations[0].latitude;
                    var longitude = userDonations[0].longitude;

                    var donationMarker = L.marker([latitude, longitude], { title: "Δωρεά", icon: wait_don }).addTo(map);
                    donationMarker.bindPopup("Username: " + username + "<br>" + popupContent);

                    donationMarkers.push(donationMarker);
            }

            }
        }
        //-------------------------------------draw polylines-----------------------------------
var polyline;
var polylines = [];
var xmlReq = new XMLHttpRequest();
var method = "GET";
var url = "get_tasks.php";
var asynchronous = true;

xmlReq.open(method, url, asynchronous);

xmlReq.onload = function () {
    if (this.readyState == 4 && this.status == 200) {
        var tasks = JSON.parse(this.responseText);
        console.log("Tasks:", tasks);

        for (var i = 0; i < tasks.length; i++) {
            var usernameRes = tasks[i].username_res;
            var carId = tasks[i].car_id;
            var destLat = tasks[i].destination_lat;
            var destLng = tasks[i].destination_lng;

            console.log("Processing task:", tasks[i]);

            switch (carId) {
                case "100":
                    console.log("Drawing polyline for carMarker1");
                    drawPolyline(carMarker1, destLat, destLng);
                    break;
                case "200":
                    console.log("Drawing polyline for carMarker2");
                    drawPolyline(carMarker2, destLat, destLng);
                    break;
                case "300":
                    console.log("Drawing polyline for carMarker3");
                    drawPolyline(carMarker3, destLat, destLng);
                    break;
                
            }
        }
    }
};

xmlReq.send();

function drawPolyline(carMarker, destLat, destLng) {
    var latlng = [];
    var latitude = carMarker.getLatLng().lat;
    var longitude = carMarker.getLatLng().lng;
    latlng.push([latitude, longitude]);
    latlng.push([destLat, destLng]);
    console.log("Polyline coordinates:", latlng);

    polyline = L.polyline(latlng, { color: 'blue' }).addTo(map);
    console.log("Polyline drawn");
    polylines.push(polyline);
}

var donpolyline;
var donpolylines = [];
var xmlDon = new XMLHttpRequest();
var method = "GET";
var url = "get_don_tasks.php";
var asynchronous = true;

xmlDon.open(method, url, asynchronous);

xmlDon.onload = function () {
    if (this.readyState == 4 && this.status == 200) {
        var tasks = JSON.parse(this.responseText);
        console.log("Tasks:", tasks);

        for (var i = 0; i < tasks.length; i++) {
            var usernameRes = tasks[i].username_res;
            var carId = tasks[i].car_id;
            var destLat = tasks[i].destination_lat;
            var destLng = tasks[i].destination_lng;

            console.log("Processing task:", tasks[i]);

            switch (carId) {
                case "100":
                    console.log("Drawing polyline for carMarker1");
                    drawDonPolyline(carMarker1, destLat, destLng);
                    break;
                case "200":
                    console.log("Drawing polyline for carMarker2");
                    drawDonPolyline(carMarker2, destLat, destLng);
                    break;
                case "300":
                    console.log("Drawing polyline for carMarker3");
                    drawDonPolyline(carMarker3, destLat, destLng);
                    break;
                }
        }
    }
};

xmlDon.send();

function drawDonPolyline(carMarker, destLat, destLng) {
    var donlatlng = [];
    var latitude = carMarker.getLatLng().lat;
    var longitude = carMarker.getLatLng().lng;
    donlatlng.push([latitude, longitude]);
    donlatlng.push([destLat, destLng]);
    console.log("Polyline coordinates:", donlatlng);

    donpolyline = L.polyline(donlatlng, { color: 'green' }).addTo(map);
    console.log("Polyline drawn");
    donpolylines.push(donpolyline);
}


        //-----------------------------toggle filters --------------------

document.getElementById('filter1').addEventListener('change', updateMarkers);

function updateMarkers() {
    console.log("updateMarkers function is called");

    var isChecked = document.getElementById("filter1").checked;

    requestMarkers.forEach(marker => {
        var egineDektoValue = marker.options.egine_dekto;
        console.log("Marker egine_dekto:", egineDektoValue);

        if (isChecked && egineDektoValue == "") {
            console.log("Adding marker to map");
            
            map.removeLayer(marker);
            
        } else {
            console.log("Removing marker from map");
            marker.addTo(map);
        }
    });
}

document.getElementById('filter2').addEventListener('change', updateReqMarkers);

function updateReqMarkers() {
    var isChecked = document.getElementById("filter2").checked;

    carMarkers.forEach(marker => map.removeLayer(marker));
    donationMarkers.forEach(marker => map.removeLayer(marker));


        requestMarkers.forEach(marker => {
            var egineDektoValue = marker.options.egine_dekto; 
        if (isChecked && egineDektoValue == "") {
            
            marker.addTo(map);
        } else {
            map.removeLayer(marker);
        }
        });
}

document.getElementById('filter3').addEventListener('change', onlyDonMarkers);

function onlyDonMarkers() {
    var isChecked = document.getElementById("filter3").checked;

    carMarkers.forEach(marker => map.removeLayer(marker));
    requestMarkers.forEach(marker => map.removeLayer(marker));
}

document.getElementById('filter6').addEventListener('change', hideReqPolylines);

function hideReqPolylines() {
    var isChecked = document.getElementById("filter6").checked;

    for (var i = 0; i < polylines.length; i++) {
        map.removeLayer(polylines[i]);
    }

    // Clear the array
    polylines = [];
}

document.getElementById('filter7').addEventListener('change', hideDonPolylines);

function hideDonPolylines() {
    var isChecked = document.getElementById("filter7").checked;

    for (var i = 0; i < donpolylines.length; i++) {
        map.removeLayer(donpolylines[i]);
    }

    // Clear the array
    donpolylines = [];
}
    </script>
</body>
</html>