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
                 <p>Name: <b><?php echo $res_name ?></b>, username: <b><?php echo $res_usname ?></b>, car id: <b><?php echo $car_id?></b></p>
                 <input type="hidden" id="currentUsername" value="<?php echo htmlspecialchars($username); ?>">
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
      <input type="checkbox" id="filter4"> Hide Request polylines
   </label>
   <span> | </span>
   <label>
      <input type="checkbox" id="filter5"> Hide Donation polylines
   </label>
</div>
            <div class="map" id="map">Χάρτης</div>
            <hr><hr><br>
            <div class="panel">
                <section class="panel_header">
                    <h2>Task List</h2>
                </section>    
                <section class="panel_body">
                    <table border=1>
                        <thead>
                            <tr>
                                <th>Full Name</th>
                                <th>Mobile</th>
                                <th>Item</th>
                                <th>Quantity(per indivdual)</th>
                                <th>Task Reg Date</th>
                                <th>Status</th> 
                            </tr>
                        </thead>
                        <tbody id="data">
                            <tr>
                            </tr>
                        </tbody>
                    </table>
                </section>
            </div> 
            <style>
                div[class="panel"] {width: 82vw; height: 90vh; background-color: #fff5; backdrop-filter: blur(7px); box-shadow: 0 .4rem .8rem #0005; border-radius: .8rem; overflow: hidden;}
                section[class="panel_header"] {width: 100%; height: 10%; backgraound-color: #fff4; padding .8rem .1rem; }
                section[class="panel_body"] {width: 95%; max-height: calc(85% - .8rem); background-color: #fffb; margin: .8rem auto; border-radius: .6rem; vertical-align: middle; overflow: auto;}
                #panel, th, td {border-collapse: collapse; padding: 1rem;}
                #thead th {position: sticky; top: 0; left: 0; background-color: #d5d1defe;}
            </style>
        </div>
        
     </main>
     
     <script>

        const map = L.map('map').setView([38.246, 21.735], 13);

        const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        const marker = L.marker([38.246, 21.735], { title:"Βάση"}).addTo(map);

        var carIcon = L.icon({
            iconUrl: 'car-svgrepo-com.svg',
            iconSize: [32, 32],
            iconAnchor: [16, 16],
            popupAnchor: [0, -16]
        });

        var wait_ait = L.icon({
            iconUrl: 'marker-16.png',
            iconSize: [32, 32],
            iconAnchor: [16, 16],
            popupAnchor: [0, -16]
        });

        var rescuerIcon = L.icon({
            iconUrl: 'person.png',
            iconSize: [32, 32],
            iconAnchor: [16, 16],
            popupAnchor: [0, -16]
        });

        var takenReq = L.icon({
            iconUrl: 'takenRequest.png',
            iconSize: [32, 32],
            iconAnchor: [16, 16],
            popupAnchor: [0, -16]
        });

        var takenDon = L.icon({
            iconUrl: 'takenDonation.png',
            iconSize: [32, 32],
            iconAnchor: [16, 16],
            popupAnchor: [0, -16]
        });

        var xhr = new XMLHttpRequest();
        var method = "GET";
        var url = "load_info_diasosti.php";
        var asynchronous = true;

        xhr.open(method, url, asynchronous);

        xhr.send();

        xhr.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var res = JSON.parse(this.responseText);
                for (var i = 0; i < res.length; i++) {

                    var latitude = res[i].latitude;
                    var longitude = res[i].longitude;

                    var resMarker = L.marker([latitude, longitude], {title:"Η θέση μου", icon: rescuerIcon}).addTo(map);
                }
            }
        }

        var latlng = [];
        var donlatlng = [];

        var ajax = new XMLHttpRequest();
        var method = "GET";
        var url = "load_car_diasosti.php";
        var asynchronous = true;

        var defaultLatitude;
        var defaultLongitude;

        ajax.open(method, url, asynchronous);

        ajax.send();

        ajax.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var car = JSON.parse(this.responseText);
                let carMarkers = [];
                for (var i = 0; i < car.length; i++) {
                    var username = car[i].username;
                    var latitude = car[i].latitude;
                    var longitude = car[i].longitude;

                    var savedPosition = JSON.parse(localStorage.getItem('carPosition_' + username));

                    if (savedPosition) {
                        latitude = savedPosition.lat;
                        longitude = savedPosition.lng;
                    }

                    latlng.push([latitude, longitude]);
                    donlatlng.push([latitude, longitude]);
                    
                    carMarker = L.marker([latitude, longitude], { title: "Όχημα: " + username, icon: carIcon, draggable: true }).addTo(map);
                    carMarker.bindPopup("Username: " + username);
                    carMarker.on('dragend', function (event) {
                        var confirmed = window.confirm('Are you sure you want to change the car\'s position?');
                        if (confirmed) {
                            var newCarPosition = event.target.getLatLng();
                            // Update the car's position in your database or perform any other necessary action.
                            console.log('New Car Position:', newCarPosition);

                            // Remove old coordinates from latlng array
                            var oldIndex = latlng.findIndex(coord => coord[0] === latitude && coord[1] === longitude);
                            if (oldIndex !== -1) {
                                latlng.splice(oldIndex, 1);
                            }

                            // Store new coordinates in latlng array
                            latlng.push([newCarPosition.lat, newCarPosition.lng]);

                            var oldIndexdon = donlatlng.findIndex(coords => coords[0] === latitude && coords[1] === longitude);
                            if (oldIndexdon !== -1) {
                                donlatlng.splice(oldIndexdon, 1);
                            }

                            // Store new coordinates in latlng array
                            donlatlng.push([newCarPosition.lat, newCarPosition.lng]);

                            localStorage.setItem('carPosition_' + username, JSON.stringify(newCarPosition));
                        } else {
                            // Revert the marker position if the user cancels the confirmation
                            event.target.setLatLng([latitude, longitude]);
                        }
                    });
                }
                
            }
        }
        var aithmaMarkers = [];
        var donationMarkers = [];
        var requestMarkers = [];
        var polylines = [];
        var donpolylines = [];

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
                        popupContent += "Όνομα: " + aithma.onoma + "<br>Κινητό: " + aithma.mobile + "<br>Προϊόν: " + aithma.proion + "<br>Ποσότητα: " + aithma.atoma + "<br>Ημερομηνία Αίτησης: " + aithma.hmerominia_aitisis + "<br><button class='btn' onclick='handleButtonClick(\"" + username + "\", " + aithma.latitude + "," + aithma.longitude + ", \"" + aithma.proion + "\", \"" + aithma.onoma + "\", " + aithma.mobile + ", " + aithma.atoma + ")'>Ανάληψη</button><br><hr><br>";
                    }
                

                    var latitude = userAithma[0].latitude;
                    var longitude = userAithma[0].longitude;

                    var storedIconState = JSON.parse(localStorage.getItem('aithmaIconState_' + username));
                    var markerIcon = storedIconState ? storedIconState : wait_ait;

                    var aithmaMarker = L.marker([latitude, longitude], { title: "Αίτημα", icon: wait_ait, egine_dekto: aithma.egine_dekto}).addTo(map);
                    aithmaMarker.bindPopup("Username: " + username + "<br>" + popupContent);
                    aithmaMarkers.push(aithmaMarker);
                    requestMarkers.push(aithmaMarker);
                }
            }
        }

        var carId = document.getElementById('carId').value;
        var polyline; // Declare the polyline variable outside the function to maintain its state


        function handleButtonClick(username, latitude, longitude, proion, onoma, mobile, atoma) {
            var checkIfTaken = new XMLHttpRequest();
                var checkIfTakenUrl = "checkTasks.php";
                var checkIfTakenData = "latitude=" + latitude + "&longitude=" + longitude + "&proion=" + proion;

                checkIfTaken.open("GET", checkIfTakenUrl + "?" + checkIfTakenData, true);
                checkIfTaken.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                checkIfTaken.onreadystatechange = function () {
                    if (checkIfTaken.readyState === 4) {
                        if (checkIfTaken.status === 200) {
                            var response = JSON.parse(checkIfTaken.responseText);

                            if (response.hasOwnProperty('message') && response.message === 'No task has been taken') {
                                const confirmYes = confirm("None has taken this task. Do you want to take it?");
                                if(confirmYes){
                                    latlng.push([latitude, longitude]);
                                    if(!polyline){
                                        polyline = L.polyline(latlng, {color: "blue"}).addTo(map);
                                    }else{
                                        polyline.setLatLngs(latlng);
                                    }
                                    polylines.push(polyline);

                                    map.fitBounds(polyline.getBounds());
                                    localStorage.setItem(currentUsername + "_polylineCoords", JSON.stringify(latlng));

                                    var updateRequest = new XMLHttpRequest();
                                    var updateMethod = "POST";
                                    var url = "update_requests.php";

                                    updateRequest.open(updateMethod, url, true);
                                    updateRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                                    updateRequest.send("latitude=" + latitude + "&longitude=" + longitude + "&proion=" + proion +  "&carId=" + carId + "&username=" + currentUsername + "&onoma=" + onoma + "&mobile=" + mobile + "&atoma=" + atoma);
                                    updateRequest.onreadystatechange = function () {
                                        if (updateRequest.readyState === 4 && updateRequest.status === 200){
                                            alert("Request accepted successfully!");
                                            var markerIndex = aithmaMarkers.findIndex(function(marker) {
        var markerLatLng = marker.getLatLng();
        return markerLatLng.lat === latitude && markerLatLng.lng === longitude;
    });

    if (markerIndex !== -1) {
        // Update the marker icon color
        aithmaMarkers[markerIndex].setIcon(takenReq);

        // Save the updated icon state to localStorage
        localStorage.setItem('aithmaIconState_' + username, JSON.stringify(takenReq));

       
        aithmaMarkers[markerIndex].closePopup();
    }
                                        }
                                    }

                                }
                            } else {
                                var res_username = response[0]['username_res'];
                                var citizenName = response[0]['citizen_name'];
                                var message = `The ${citizenName}'s request has already been taken by ${res_username}`;
                                alert(message);
                            }
                        } else {
                            console.log("Error: HTTP status code", checkIfTaken.status);
                            alert("Error: Unable to check task status.");
                        }
                    }
                };

                checkIfTaken.send();
            }

        var currentUsername = document.getElementById('currentUsername').value;
        var storedCoords = localStorage.getItem(currentUsername + "_polylineCoords");
        if (storedCoords) {
            latlng = JSON.parse(storedCoords);
            polyline = L.polyline(latlng, { color: "blue" }).addTo(map);
            map.fitBounds(polyline.getBounds());
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
                        popupContent += "Όνομα: " + donation.onoma + "<br>Κινητό: " + donation.mobile + "<br>Προϊόν: " + donation.proion + "<br>Ποσότητα: " + donation.atoma + "<br>Ημερομηνία Αίτησης: " + donation.hmerominia_doreas + "<br><button class='btn' onclick='handleDonButtonClick(" + donation.latitude + "," + donation.longitude + ", \"" + donation.proion + "\", \"" + donation.onoma + "\", " + donation.mobile + ", " + donation.atoma + ")'>Ανάληψη</button><br><br>";
                }
                

                    var latitude = userDonations[0].latitude;
                    var longitude = userDonations[0].longitude;

                    var donationMarker = L.marker([latitude, longitude], { title: "Δωρεά", icon: wait_don }).addTo(map);
                    donationMarker.bindPopup("Username: " + username + "<br>" + popupContent);
                    donationMarkers.push(donationMarker);
            }

            }
        }
        var storedDonationsIconState = localStorage.getItem(currentUsername + '_donationsIconState');
        if (storedDonationsIconState) {
            var donationsIconState = JSON.parse(storedDonationsIconState);
            // Apply the stored icon state to donationsMarker
            donationMarker.setIcon(donationsIconState);
        }
        
        var donpolyline;
        function handleDonButtonClick(latitude, longitude, proion, onoma, mobile, atoma) {
            var checkIfTaken = new XMLHttpRequest();
                var checkIfTakenUrl = "checkTasks.php";
                var checkIfTakenData = "latitude=" + latitude + "&longitude=" + longitude + "&proion=" + proion;

                checkIfTaken.open("GET", checkIfTakenUrl + "?" + checkIfTakenData, true);
                checkIfTaken.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                checkIfTaken.onreadystatechange = function () {
                    if (checkIfTaken.readyState === 4) {
                        if (checkIfTaken.status === 200) {
                            var response = JSON.parse(checkIfTaken.responseText);

                            if (response.hasOwnProperty('message') && response.message === 'No task has been taken') {
                                const confirmYes = confirm("None has taken this task. Do you want to take it?");
                                if(confirmYes){
                                    donlatlng.push([latitude, longitude]);
                                    if(!donpolyline){
                                        donpolyline = L.polyline(donlatlng, {color: "green"}).addTo(map);
                                        
                                    }else{
                                        donpolyline.setLatLngs(donlatlng);
                                    }
                                    donpolylines.push(donpolyline);

                                    map.fitBounds(donpolyline.getBounds());
                                    localStorage.setItem(currentUsername + "_donpolylineCoords", JSON.stringify(donlatlng));

                                    var updateRequest = new XMLHttpRequest();
                                    var updateMethod = "POST";
                                    var url = "update_donation.php";

                                    updateRequest.open(updateMethod, url, true);
                                    updateRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                                    updateRequest.send("latitude=" + latitude + "&longitude=" + longitude + "&proion=" + proion +  "&carId=" + carId + "&username=" + currentUsername + "&onoma=" + onoma + "&mobile=" + mobile + "&atoma=" + atoma);
                                    updateRequest.onreadystatechange = function () {
                                        if (updateRequest.readyState === 4 && updateRequest.status === 200){
                                            alert("Donation accepted successfully!");
                                        }
                                    }

                                }
                            } else {
                                var res_username = response[0]['username_res'];
                                var citizenName = response[0]['citizen_name'];
                                var message = `The ${citizenName}'s donation has already been taken by ${res_username}`;
                                alert(message);
                            }
                        } else {
                            console.log("Error: HTTP status code", checkIfTaken.status);
                            alert("Error: Unable to check task status.");
                        }
                    }
                };

                checkIfTaken.send();
            }

        var donstoredCoords = localStorage.getItem(currentUsername + "_donpolylineCoords");
        if (donstoredCoords) {
            donlatlng = JSON.parse(donstoredCoords);
            donpolyline = L.polyline(donlatlng, { color: "green" }).addTo(map);
            map.fitBounds(polyline.getBounds());
        }

    var ajax = new XMLHttpRequest();
        var method = "GET";
        var url = "getTasks.php";
        var asynchronous = true;

        ajax.open(method, url, asynchronous);

        ajax.send();

        ajax.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var data = JSON.parse(this.responseText);
                
                var html = "";
                for (var i = 0; i < data.length; i++) {
                    var taskId = data[i].id_task;
                    var taskType = data[i].eidos_task;
                    var citizen_name = data[i].citizen_name;
                    var citizen_mobile = data[i].citizen_mobile;
                    var proion = data[i].proion;
                    var atoma = data[i].atoma;
                    var hmerominia_analipsis = data[i].hmerominia_analipsis;
                    var task_status = data[i].task_status;
                        
                        html += "<tr id='row_" + taskId + "'>";
                        html += "<td>" + citizen_name + "</td>";
                        html += "<td>" + citizen_mobile + "</td>";
                        html += "<td>" + proion + "</td>";
                        html += "<td>" + atoma + "</td>";
                        html += "<td>" + hmerominia_analipsis + "</td>";
                        html += "<td>" + task_status + "</td>";
                        html += "<td><button onclick = 'completeTask(\"" + taskId + "\", \"" + taskType + "\", \"" + citizen_name + "\", \"" + citizen_mobile + "\", \"" + proion + "\", " + atoma + ")'><span class = 'tick-icon'>&#10003</span></button></td><td><button onclick = 'deleteTask(\"" + taskId + "\", \"" + taskType + "\", \"" + citizen_name + "\", \"" + citizen_mobile + "\", \"" + proion + "\")'><span class = 'delete-icon'>&#10007</span></button></td></tr>";
                }
                document.getElementById("data").innerHTML = html;
            }
        }

        function deleteTask(taskId, taskType, citizenName, citizenMobile, proion){
            //remove the task from the table
            var row = document.getElementById("row_" + taskId);
            row.parentNode.removeChild(row);
            
            if(taskType == 'Request'){
                if (polyline) {
                    map.removeLayer(polyline);
                    polyline = null;
                    // clear the localStorage as well
                    localStorage.removeItem(currentUsername + "_polylineCoords");
                }

            }else{
                if (donpolyline) {
                    map.removeLayer(donpolyline);
                    donpolyline = null;
                    // clear the localStorage as well
                    localStorage.removeItem(currentUsername + "_donpolylineCoords");
                }
            }

            var updateTasks = new XMLHttpRequest();
            var updateMethod = "POST";
            var url = "updateTasks.php";

            updateTasks.open(updateMethod, url, true);
            updateTasks.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            var params = "taskId=" + encodeURIComponent(taskId) + "&taskType=" + encodeURIComponent(taskType) + "&citizenName=" + encodeURIComponent(citizenName) + "&citizenMobile=" + encodeURIComponent(citizenMobile) + "&proion=" + encodeURIComponent(proion);
            updateTasks.send(params);
            updateTasks.onreadystatechange = function () {
                if (updateTasks.readyState === 4 && updateTasks.status === 200){
                    alert("Task deleted successfully!");
                    
                }
            }
        }

        function completeTask(taskId, taskType, citizenName, citizenMobile, proion, atoma){
            //remove the task from the table
            var row = document.getElementById("row_" + taskId);
            row.parentNode.removeChild(row);
            
            if(taskType == 'Request'){
                if (polyline) {
                    map.removeLayer(polyline);
                    polyline = null;
                    // clear the localStorage as well
                    localStorage.removeItem(currentUsername + "_polylineCoords");
                }

            }else{
                if (donpolyline) {
                    map.removeLayer(donpolyline);
                    donpolyline = null;
                    // clear the localStorage as well
                    localStorage.removeItem(currentUsername + "_donpolylineCoords");
                }
            }

            var updateTasks = new XMLHttpRequest();
            var updateMethod = "POST";
            var url = "completeTasks.php";

            updateTasks.open(updateMethod, url, true);
            updateTasks.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            var params = "carId" + encodeURIComponent(carId) +"&taskId=" + encodeURIComponent(taskId) + "&taskType=" + encodeURIComponent(taskType) + "&citizenName=" + encodeURIComponent(citizenName) + "&citizenMobile=" + encodeURIComponent(citizenMobile) + "&proion=" + encodeURIComponent(proion) + "&atoma" + encodeURIComponent(atoma);
            updateTasks.send(params);
            updateTasks.onreadystatechange = function () {
                if (updateTasks.readyState === 4 && updateTasks.status === 200){
                    alert("Task completed successfully!");
                    
                }
            }
        }

//--------------------------------filters--------------------------------
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

    requestMarkers.forEach(marker => map.removeLayer(marker));
}

document.getElementById('filter4').addEventListener('change', hideReqPolylines);

function hideReqPolylines() {
    var isChecked = document.getElementById("filter4").checked;

    for (var i = 0; i < polylines.length; i++) {
        map.removeLayer(polylines[i]);
    }

    // Clear the array
    polylines = [];
}

document.getElementById('filter5').addEventListener('change', hideDonPolylines);

function hideDonPolylines() {
    var isChecked = document.getElementById("filter5").checked;

    for (var i = 0; i < donpolylines.length; i++) {
        map.removeLayer(donpolylines[i]);
    }

    // Clear the array
    donpolylines = [];
}
</script>
</body>
</html>