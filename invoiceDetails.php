<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Invoice</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
  <body>
        <div class="container">
            <div class="row">
              <div class="col-md-16">
                <div class="card" >
                  <div class="card-header">
                     <h1 class=text-center>Invoice List</h1> </div>
                     <div class="card-body">
                     <button class="btn btn-success"><a href="index.php" class="text-light text-decoration-none">Add New</a></button>
                        <br/>
                        <br/>
                       <table class="table">
                        <thead>
                            <tr>
                               <th scope="col">ID</th>
                               <th scope="col">INVOICE_NO</th>
                              <th scope="col">INVOICE_DATE</th>
                              <th scope="col">NAME</th>
                              <th scope="col">ADDRESS</th>
                              <th scope="col">CITY</th>
                              <th scope="col">GRAND TOTAL</th>
                              <th scope="col">PRINT DOC</th>
                              <th scope="col">DELETE</th>
                            </tr> 
                        </thead> 
                        <tbody>
    <?php
        $connection = mysqli_connect("localhost","root","");
        $db = mysqli_select_db($connection,"invoice_db");

        $sql = "select * from invoice";
       
        
        $data = mysqli_query($connection,$sql);

            while($row = mysqli_fetch_array($data)){
                  $sid=$row['SID'];
                   $invoice_no  = $row ['INVOICE_NO'];
                   $invoice_date  = date("d-m-Y",strtotime($row["INVOICE_DATE"]));
                   $cname =$row['CNAME'];
                   $address  = $row ['ADDRESS'];
                   $city=$row['CITY'];
                   $grand_total=$row['GRAND_TOTAL'];

     ?>
  
                          <tr>
                            <td><?php echo $sid ?></td>
                            <td><?php echo $invoice_no ?></td>
                            <td><?php echo $invoice_date ?></td>
                            <td><?php echo $cname ?></td>
                            <td><?php echo $address ?></td>
                            <td><?php echo $city ?></td>
                            <td><?php echo $grand_total ?></td>
                            <td>
                              <button class="btn btn-success">
                                <a href ='print.php?id=<?php echo $sid ?>' class="text-light text-decoration-none">Print</a></button>
                              </td>
                              <td> 
                                 <button class="btn btn-danger"><a href ='invoiceDel.php?del=<?php echo $sid ?>' class="text-light text-decoration-none">Delete</a></button>&nbsp;

                          </td>

                          </tr>
                        
  <?php  } ?>

                        </tbody>
                     </table>
                  </div>
                </div>
        
            </div>
        </div>

    </div>
    







  </body>
</html>