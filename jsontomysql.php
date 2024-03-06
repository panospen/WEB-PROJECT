<?php 
   
   include("php/config.php");

   $filenamee = "categories.json";

   $dataa = file_get_contents($filenamee);

   
   
   $categories = json_decode($dataa, JSON_OBJECT_AS_ARRAY);


   foreach($categories as $category){
      $id = $category["id"];
      $category_name = $category["category_name"];

      $queryyy = "INSERT INTO categories(cat_id, cat_name) VALUES ('$id','$category_name')";
      mysqli_query($con, $queryyy);
   }

   $filename = "items.json";

    $data = file_get_contents($filename);
 
    
    
    $products = json_decode($data, JSON_OBJECT_AS_ARRAY);
 
    foreach($products as $product){
     $id = $product["id"];
     $name =  $product["name"];
     $category = $product["category"];
 
     $query = "INSERT INTO products(id, pr_name, category) VALUES ('$id','$name','$category')";
     mysqli_query($con, $query);  
 
     $details = $product['details'];
     foreach($details as $detail){
        $detail_name = $detail["detail_name"];
        $detail_value = $detail["detail_value"];
 
        $queryy = "INSERT INTO product_details(pr_id, detail_name, detail_value) VALUES ('$id','$detail_name','$detail_value')";
        mysqli_query($con, $queryy);
       }
     
    }

?>