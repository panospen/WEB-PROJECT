<?php 
         
         include("php/config.php");
         if(isset($_POST['submit'])){
            $username = $_POST['username'];
            $password = $_POST['password'];
            $name = $_POST['name'];
            $mobile = $_POST['mobile'];
            $car_dist = $_POST['car_dist'];
            $latitude = $_POST['latitude'];
            $longitude = $_POST['longitude'];

            $verify_query = mysqli_query($con,"SELECT username FROM users WHERE username='$username'");

         if(mysqli_num_rows($verify_query) !=0 ){
            echo "<div class='message'>
                      <p>This username is used, Try another One Please!</p>
                  </div> <br>";
            echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";
         }
         else{

            mysqli_query($con,"INSERT INTO users(id, username, password, name, mobile, latitude, longitude) VALUES('diasostis','$username','$password','$name','$mobile', '$latitude', '$longitude')") or die("apotuxia");
            mysqli_query($con,"INSERT INTO logintable(username, password) VALUES('$username','$password')") or die("apotuxia");
            mysqli_query($con,"INSERT INTO diasostes(username, car_id) VALUES('$username','$car_dist')") or die("apotuxia");

            echo "<div class='message'>
                      <p>Registration successfully!</p>
                  </div> <br> <style> div[class=message]{width: 230px; height: 135px;}</style>";
                  echo "<a href='adminCrRescAcc.php'><button class='btn'>OK</button>";
         

         }
        }
?>