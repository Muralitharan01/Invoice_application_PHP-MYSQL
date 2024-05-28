<?php
$conn=mysqli_connect("localhost","root","","invoice_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['query'])) {
    $query = $_POST['query'];
    $sql = "SELECT * FROM supplier_list WHERE company_name LIKE '%$query%' LIMIT 5";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<div data-company_name='" . htmlspecialchars($row['company_name']) .
             "' data-company_address='" . htmlspecialchars($row['company_address']) 
            . "' data-contact='" . htmlspecialchars($row['contact']) . "'>";
            echo htmlspecialchars($row['company_name']);
            echo "</div>";
        }
    } else {
        echo "<div>No results</div>";
    }
}

$conn->close();
?>
