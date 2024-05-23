<?php
 $conn = mysqli_connect('localhost','root','','invoice_db');

 $city_id =  $_POST['city_data'];
 
$pincode = "SELECT * FROM table_name WHERE city_id = $city_id";
$pincode_qry = mysqli_query($conn, $pincode);


$output="";
while ($pincode_row = mysqli_fetch_assoc($pincode_qry)) {
    $output .=  $pincode_row['Pincode'];
};
echo $output;