<?php
$conn = mysqli_connect('localhost','root','','invoice_db');
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get the form data
  $p_name = $_POST['product_name'];
  $p_price= $_POST['product_price'];
 
  // Insert data into the database
  $sql = "INSERT INTO product_list(PRODUCT_NAME,PRODUCT_PRICE) 
  VALUES ('$p_name', '$p_price')";

  if ($conn->query($sql) === TRUE) {
    echo"<div class='alert alert-success text-center'>New Product Added  see<a href='productlist.php'>Product List</a></div>";
  } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
  }};
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
 
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
    <form method='post' action='addProduct.php' >
        <div class='row'>
            <div class='col-md-4'>
                <h5 class='text-success'>Add Product List</h5>
                <div class='form-group'>
                        <label>Product Name:</label>
                        <input type='text' name='product_name' required class='form-control'/>
                </div>
                <div class='form-group'>
                        <label>Product Price:</label>
                        <input type='text' name='product_price' id='Product_price' required  class='form-control'/>
                </div>
                <input type='submit' name='submit' value='Save' class='btn btn-success float-right'/>
            
            </div>
        </div>
    </form>
</div>
    
</body>
</html>