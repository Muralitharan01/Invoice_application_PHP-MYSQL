<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Invoice</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
  <body>
        <div class="container pt-4">
            <div class="row">
              <div class="col-md-16">
                <div class="card" >
                  <div class="card-header">
                     <h3 class=text-center>Customer List</h3> </div>
                     <div class="card-body">
                     <button class="btn btn-success"><a href="addcustomer.php" class="text-light text-decoration-none">Create New Customer</a></button>
                        <br/>
                        <br/>
                       <table class="table">
                        <thead>
                            <tr>
                               <th scope="col">ID</th>
                               <th scope="col">NAME</th>
                              <th scope="col">ADDRESS</th>
                              <th scope="col">CITY</th>
                              <th scope="col">MOBILE</th>
                              <th scope="col">UPDATE</th> 
                               <th scope="col">DELETE</th>
                             </tr> 
                        </thead> 
                        <tbody>
    <?php
        $connection = mysqli_connect("localhost","root","");
        $db = mysqli_select_db($connection,"invoice_db");

        $sql = "select * from add_customer";
            
        $data = mysqli_query($connection,$sql);

            while($row = mysqli_fetch_array($data)){
                  $cid=$row['ID'];
                   $cname  = $row ['CUSNAME'];
                   $caddress  = $row["CUSADDRESS"];
                   $ccity =$row['CUSCITY'];
                   $cmobile  = $row ['CUSMOBILE'];
   

     ?>
  
                          <tr>
                            <td><?php echo $cid ?></td>
                            <td><?php echo $cname ?></td>
                            <td><?php echo $caddress ?></td>
                            <td><?php echo $ccity ?></td>
                            <td><?php echo $cmobile ?></td>
                          
                            <td> 
                                 <button class="btn btn-warning">
                                    <a href ='updatecustomer.php?update=<?php echo $cid ?>' class="text-light text-decoration-none">UPDATE</a></button>

                          </td>
                           <td> 
                                 <button class="btn btn-danger">
                                    <a href ='customerDel.php?cusdel=<?php echo $cid ?>' class="text-light text-decoration-none">Delete</a></button>

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