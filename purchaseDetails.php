<?php
session_start();
include 'include_common/header.php' ?>

        <div class="container mt-4 ">
            <div class="row">
              <div >
                
                  <div class="font-monospace">
                     <h2 class=text-center>Purchase List</h2> 
                     
                       <table class="table">
                        <thead class='bg-secondary'>
                            <tr>
                               <th scope="col">ID</th>
                               <th scope="col">BILL_NO</th>
                              <th scope="col">BILL_DATE</th>
                              <th scope="col">COMPANYNAME</th>
                              <th scope="col">COMPANYADDRESS</th>
                              <th scope="col">GRAND TOTAL</th>
                              <th scope="col">VIEW</th>
                              <th scope="col">DELETE</th>
                            </tr> 
                        </thead> 
                        <tbody>
    <?php
        $connection = mysqli_connect("localhost","root","");
        $db = mysqli_select_db($connection,"invoice_db");

        $sql = "select * from purchase_bill";
       
        
        $data = mysqli_query($connection,$sql);

            while($row = mysqli_fetch_array($data)){
                  $id=$row['Purchse_ID'];
                   $bill_no  = $row ['BILL_NO'];
                  $bill_date  = date("d-m-Y",strtotime($row["BILL_DATE"]));
                   $companyname =$row['COMPANYNAME'];
                   $companyaddress  = $row ['COMPANYADDRESS'];
                   $grand_total=$row['GRAND_TOTAL'];

     ?>
  
                          <tr>
                            <td><?php echo $id ?></td>
                            <td><?php echo $bill_no ?></td>
                            <td><?php echo $bill_date ?></td>
                            <td><?php echo $companyname ?></td>
                            <td><?php echo $companyaddress ?></td>
                            <td><?php echo $grand_total ?></td>
                            <td> 
                                 <button class="btn btn-info">
                                  <a href ='purchaseproductview.php?view=<?php echo $id ?>' class="text-light text-decoration-none">view</a></button>&nbsp;
                          </td>
                              <td> 
                                 <button class="btn btn-danger">
                                  <a href ='purchaseListDel.php?del=<?php echo $id ?>' class="text-light text-decoration-none">Delete</a></button>&nbsp;
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