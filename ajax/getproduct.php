<?php
// Create connection
$conn=mysqli_connect("localhost","root","","invoice_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['query'])) {
    $query = $_POST['query'];
    $sql = "SELECT * FROM product_list WHERE PRODUCT_NAME LIKE '%$query%' LIMIT 5";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<div data-productname='" . htmlspecialchars($row['PRODUCT_NAME']) . "' data-productprice='" . htmlspecialchars($row['PRODUCT_PRICE']) . "'>";
            echo htmlspecialchars($row['PRODUCT_NAME']);
            echo "</div>";
        }
    } else {
        echo "<div>No results</div>";
    }
}

$conn->close();
?>
