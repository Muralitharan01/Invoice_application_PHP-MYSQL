<?php
session_start();
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


  include 'include_common/header.php' ?>

   <div class='container addproduct_page'>
    <form method='post' action='addProduct.php' >
        <div class='row'>
            <div >
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