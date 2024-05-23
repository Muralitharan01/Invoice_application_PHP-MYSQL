<?php
 $conn = mysqli_connect('localhost','root','','invoice_db');

$state_id =  $_POST['state_data'];

$city = "SELECT * FROM table_name WHERE state_id = $state_id";
$city_qry = mysqli_query($conn, $city);


$output = '<option value="">Select City</option>';

while ($city_row = mysqli_fetch_assoc($city_qry)) {
    $output .= '<option value="' . $city_row['city_id'] . '">' . $city_row['PostOfficeName'] . '</option>';
}

echo $output;

