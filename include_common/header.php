<?php


if (!isset($_SESSION['userid'])) {
    header("Location: Login.php");
    return;
     }

?>


<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Invoice</title>
    
    <!-- Jquery CDN -->
    <link rel='stylesheet' href='https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css'>
   
    <link rel="stylesheet" href="style.css">

   
</head>

<body >
    
<div class="header">
<header >
        <nav>
            <div class="menu-toggle" id="menu-toggle">
                ☰
            </div>
            <ul id="menu" class="menu text-center ">
                <li><a class='list text-decoration-none' href="LoginuserDetail.php">Profile</a></li>
                <li><a class='list text-decoration-none' href="index.php">Create New Invoice</a></li>
                <li><a class='list text-decoration-none' href="invoiceDetails.php">Invoice List</a></li>
                <li><a class='list text-decoration-none' href="addcustomer.php">Add Customer </a></li>
                <li><a class='list text-decoration-none' href="customerDeatails.php">Customer List</a></li>
                <li><a class='list text-decoration-none' href="addProduct.php">Add Product</a></li>   
                <li><a class='list text-decoration-none' href="productlist.php">Product List</a></li>
                <li><a class='list text-decoration-none' href="supplierList.php">SupplierList</a></li>
                <li><a class='list text-decoration-none' href="addsupplier.php">Add Supplier</a></li>
                <li><a class='list text-decoration-none' href="purchaseDetails.php">Purchase Details</a></li>
                <li><a class='list text-decoration-none' href="purchaseBill.php">Purchase Bill</a></li>
            
            </ul>
        </nav>
    </header> 
</div>
  <script>
    
document.addEventListener('DOMContentLoaded', function() {
    var menuToggle = document.getElementById('menu-toggle');
    var menu = document.getElementById('menu');

    menuToggle.addEventListener('click', function() {
        menu.classList.toggle('active');
    });
});

 
  </script>