<?php
// Create connection
$conn=mysqli_connect("localhost","root","","invoice_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['query'])) {
    $query = $_POST['query'];
    $sql = "SELECT * FROM add_customer WHERE CUSNAME LIKE '%$query%' LIMIT 5";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<div data-customername='" . htmlspecialchars($row['CUSNAME']) .
             "' data-customeraddress='" . htmlspecialchars($row['CUSADDRESS']) 
            . "' data-customercity='" . htmlspecialchars($row['CUSCITY']) 
            . "' data-customermobile='" . htmlspecialchars($row['CUSMOBILE']) . "'>";
            echo htmlspecialchars($row['CUSNAME']);
            echo "</div>";
        }
    } else {
        echo "<div>No results</div>";
    }
}

$conn->close();
?>
