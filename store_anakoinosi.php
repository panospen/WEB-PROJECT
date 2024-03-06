<?php 
    
    include("php/config.php");
    if(isset($_POST['submit'])){
        $text = $_POST['bigText']; 

        mysqli_query($con,"INSERT INTO anakoinoseis(keimeno, hmerominia_dimosieusis) VALUES('$text', current_timestamp())") or die("apotuxia");
        
        echo "<div class='message'>
                  <p>Registration successfully!</p>
                  </div> <br> <style> div[class=message]{width: 230px; height: 135px;}</style>";
        echo "<a href='adminAnak.php'><button class='btn'>OK</button>";
         

     }
    
?>