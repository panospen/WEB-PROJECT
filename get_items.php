<?php
include("php/config.php");

if (isset($_POST['cat_id'])) {
    $item_sel = "SELECT pr_name, quantity FROM products WHERE category = " . $_POST['cat_id'];
    $item_cat_sel = mysqli_query($con, $item_sel);

    if ($item_cat_sel) {
        if (mysqli_num_rows($item_cat_sel) > 0) {
            echo '<table>';
            echo '<thead><tr><th>Product Name</th><th>Quantity in Inventory</th><th>Quantity in Cars</th></tr></thead>';
            echo '<tbody>';

            while ($items = mysqli_fetch_assoc($item_cat_sel)) {
                $escaped_pr_name = mysqli_real_escape_string($con, $items['pr_name']);
                $car_quan_query = "SELECT quantity FROM loads WHERE pr_name = '$escaped_pr_name'";
                
                // Execute the query
                $car_quan = mysqli_query($con, $car_quan_query);

                if ($car_quan) {
                    // Check if there are rows in the result set
                    if (mysqli_num_rows($car_quan) > 0) {
                        while ($quan = mysqli_fetch_assoc($car_quan)) {
                            echo '<tr>';
                            echo '<td>' . $items['pr_name'] . '</td>';
                            echo '<td>' . $items['quantity'] . '</td>';
                            echo '<td>' . $quan['quantity'] . '</td>';
                            echo '</tr>';
                        }
                    } else {
                        // Output a message when no quantity is found in the car
                        echo '<tr>';
                        echo '<td>' . $items['pr_name'] . '</td>';
                        echo '<td>' . $items['quantity'] . '</td>';
                        echo '<td>No quantity in car</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<p>Error in car quantity query: ' . mysqli_error($con) . '</p>';
                }
            }

            echo '</tbody>';
            echo '</table>';
        } else {
            echo '<p>No items found</p>';
        }
    } else {
        echo '<p>Error in product query execution: ' . mysqli_error($con) . '</p>';
    }
}
?>
