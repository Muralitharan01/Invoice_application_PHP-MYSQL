<?php
$conn = mysqli_connect('localhost','root','','invoice_db');
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET["update"])) {
    $sql = "SELECT * FROM product_list WHERE PRODUCT_ID='{$_GET["update"]}'";
    $data = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_array($data)) {
        $pid = $row['PRODUCT_ID'];
        $p_name = $row['PRODUCT_NAME'];
        $p_price = $row["PRODUCT_PRICE"];
    }}
?><?php
$connc = mysqli_connect('localhost','root','','invoice_db');
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
        $productname = mysqli_real_escape_string($connc, $_POST['product_name']);
        $productprice = mysqli_real_escape_string($connc, $_POST['product_price']);
        $productid = mysqli_real_escape_string($connc, $_POST['product_id']);

         $update_query = "UPDATE product_list SET PRODUCT_NAME = '$productname', PRODUCT_PRICE = '$productprice' WHERE PRODUCT_ID= $productid";
        if (mysqli_query($connc, $update_query)) {
            echo '<script> location.replace ("productlist.php")</script>';

           
        } else {
            echo "Error updating record: " . mysqli_error($connc);
        }
    
    }    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    
    <link rel='stylesheet' href='https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css'>
    <script src="https://code.jquery.com/ui/1.13.0-rc.3/jquery-ui.min.js" integrity="sha256-R6eRO29lbCyPGfninb/kjIXeRjMOqY3VWPVk6gMhREk=" crossorigin="anonymous"></script>
    </head>
<body>
   <div class='container pt-2'>
   <button class="btn btn-success d-md-flex justify-content-md-end"><a href="index.php" class="text-light text-decoration-none border border-success">Create Bill</a></button>
    <form method='post' action='updateproduct.php' >
        <div class='row'>
            <div class='col-md-4'>
                <h5 class='text-warning'>Update Product</h5>
                <div class='form-group'>
                        <label>Product Name:</label>
                        <input type='text' value='<?php echo $p_name?>' name='product_name' required class='form-control'/>
                </div>
                <div class='form-group'>
                        <label>Product Price:</label>
                        <input type='text' value='<?php echo $p_price?>' name='product_price' id='Product_price' required  class='form-control'/>
                </div>
                <input type='hidden' name='product_id' value='<?php echo $pid; ?>'/>
                <input type='submit' name='submit' value='update' class='btn btn-warning float-right'/>
            
            </div>
        </div>
    </form>
</div>
    
</body>
</html>