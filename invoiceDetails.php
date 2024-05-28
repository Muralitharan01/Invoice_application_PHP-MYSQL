<?php
session_start();
include 'include_common/header.php' ?>

        <div class="container mt-4 ">
            <div class="row">
              <div >
                
                  <div class="font-monospace">
                     <h2 class=text-center>Invoice List</h2> 
                     
                       <table class="table">
                        <thead class='bg-secondary'>
                            <tr>
                               <th scope="col">ID</th>
                               <th scope="col">INVOICE_NO</th>
                              <th scope="col">INVOICE_DATE</th>
                              <th scope="col">NAME</th>
                              <th scope="col">ADDRESS</th>
                              <th scope="col">CITY</th>
                              <th scope="col">MOBILE_NO</th>
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
                   $cmobile=mysqli_real_escape_string($connection,$row['MOBILE_NO']);
                   $grand_total=$row['GRAND_TOTAL'];

     ?>
  
                          <tr>
                            <td><?php echo $sid ?></td>
                            <td><?php echo $invoice_no ?></td>
                            <td><?php echo $invoice_date ?></td>
                            <td><?php echo $cname ?></td>
                            <td><?php echo $address ?></td>
                            <td><?php echo $city ?></td>
                            <td><?php echo $cmobile ?></td>
                            <td><?php echo $grand_total ?></td>
                            <td>
                              <button class="btn btn-success">
                                <a href ='print.php?id=<?php echo $sid ?>' class="text-light text-decoration-none">Print</a></button>
                              </td>
                              <td> 
                                 <button class="btn btn-danger">
                                  <a href ='invoiceDel.php?del=<?php echo $sid ?>' class="text-light text-decoration-none">Delete</a></button>&nbsp;
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