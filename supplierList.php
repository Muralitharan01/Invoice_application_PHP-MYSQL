<?php
session_start();
include 'include_common/header.php' ?>
        <div class="container mt-4 ">
            <div class="row">
              <div class="col-md-16">
                <div >
                  <div class=" bg-cyan font-monospace">
                     <h3 class=text-center>Supplier List</h3> </div>
                       <table class="table mt-2">
                        <thead class='bg-secondary'>
                            <tr>
                               <th scope="col">Company ID</th>
                               <th scope="col">Company Name</th>
                               <th scope="col">Company Address</th>
                               <th scope="col">Contact</th>
                              <th scope="col">UPDATE</th> 
                               <th scope="col">DELETE</th>
                             </tr> 
                        </thead> 
                        <tbody>
    <?php
        $connection = mysqli_connect("localhost","root","");
        $db = mysqli_select_db($connection,"invoice_db");

        $sql = "select * from supplier_list";
            
        $data = mysqli_query($connection,$sql);

            while($row = mysqli_fetch_array($data)){
                  $company_id=$row['supplier_id'];
                   $company_name  = $row ['company_name'];
                   $company_address  = $row["company_address"];
                   $contact  = $row["contact"];

                 
     ?>
  
                          <tr>
                            <td><?php echo $company_id ?></td>
                            <td><?php echo $company_name ?></td>
                            <td><?php echo $company_address ?></td>
                            <td><?php echo $contact ?></td>
                            <td> 
                                 <button class="btn btn-warning">
                                    <a href ='supplierDetailUpdate.php?update=<?php echo $company_id ?>' class="text-light text-decoration-none">UPDATE</a></button>

                          </td>
                           <td> 
                                 <button class="btn btn-danger">
                                    <a href ='supplierDel.php?supplierdel=<?php echo $company_id ?>' class="text-light text-decoration-none">Delete</a></button>

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