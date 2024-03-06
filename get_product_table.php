<?php
    $k = $_POST['id'];
    $k = trim($k);
    include("php/config.php");
    $item_sel = "SELECT id, pr_name, quantity from products WHERE category ='{$k}'";
    $item_cat_sel = mysqli_query($con, $item_sel);
    while($rows = mysqli_fetch_array($item_cat_sel)){
?>
    <tr>
        <td value = "<?php $rows['id'] ?>"><?php echo $rows['pr_name']?></td>
    
        <td><?php echo $rows['quantity']?></td>
    </tr>
<?php
    }
    echo $item_sel;
?>
