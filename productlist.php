<?php
session_start();
include 'include_common/header.php' ?>
        <div class="container mt-4 ">
            <div class="row">
              <div class="col-md-16">
                <div >
                  <div class=" bg-cyan font-monospace">
                     <h3 class=text-center>Product List</h3> </div>
                       <table class="table mt-2">
                        <thead class='bg-secondary'>
                            <tr>
                               <th scope="col">ID</th>
                               <th scope="col">PRODUCT NAME</th>
                               <th scope="col">STOCKS</th>
                              <th scope="col">PRICE</th>
                              <th scope="col">UPDATE</th> 
                               <th scope="col">DELETE</th>
                             </tr> 
                        </thead> 
                        <tbody>
    <?php
        $connection = mysqli_connect("localhost","root","");
        $db = mysqli_select_db($connection,"invoice_db");

        $sql = "select * from product_list";
            
        $data = mysqli_query($connection,$sql);

            while($row = mysqli_fetch_array($data)){
                  $pid=$row['PRODUCT_ID'];
                   $p_name  = $row ['PRODUCT_NAME'];
                   $p_price  = $row["PRODUCT_PRICE"];
                   $stocks  = $row["item_qty"];

                 
     ?>
  
                          <tr>
                            <td><?php echo $pid ?></td>
                            <td><?php echo $p_name ?></td>
                            <td><?php echo $stocks ?></td>
                            <td><?php echo $p_price ?></td>
                            <td> 
                                 <button class="btn btn-warning">
                                    <a href ='updateproduct.php?update=<?php echo $pid ?>' class="text-light text-decoration-none">UPDATE</a></button>

                          </td>
                           <td> 
                                 <button class="btn btn-danger">
                                    <a href ='productDel.php?pdel=<?php echo $pid ?>' class="text-light text-decoration-none">Delete</a></button>

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