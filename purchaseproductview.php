<?php
session_start();
        $connection = mysqli_connect("localhost","root","");
        $db = mysqli_select_db($connection,"invoice_db");

        $sql = "SELECT * FROM purchase_bill WHERE Purchse_ID='{$_GET["view"]}'";

       
        
        $data = mysqli_query($connection,$sql);

            while($row = mysqli_fetch_array($data)){
                  $id=$row['Purchse_ID'];
                   $bill_no  = $row ['BILL_NO'];
                  $bill_date  = date("d-m-Y",strtotime($row["BILL_DATE"]));
                   $companyname =$row['COMPANYNAME'];
                   $companyaddress  = $row ['COMPANYADDRESS'];
                   $grand_total=$row['GRAND_TOTAL'];
            }


          include 'include_common/header.php'    
          ?>
      <form class='container mt-4' >
        <h2 class='text-center text-info'>Purchase Bill </h2>
        <button class='bg-info float-right' ><a href='purchasedetails.php' class='text-decoration-none  text-dark'>Back</a></button>

        <div class='row'>
            <div class='col-md-4'>
                <h5 class='text-info'>Bill Details</h5>
                <div class='form-group'>
                        <label>Bill NO</label>
                        <input type='text' value=<?php echo$bill_no ?> readonly class='form-control' readonly/>
                </div>
                <div class='form-group'>
                        <label>Bill Date</label>
                        <input type='text'  value=<?php echo$bill_date ?> name='bill_date' id='bill_date' readonly  class='form-control' readonly/>
                </div>
            </div>
            <div class='col-md-8'>
                <h5 class='text-info'>Supplier Details</h5>
                <div class='form-group'>
                        <label>Company Name</label>
                        <input type='text' value='<?php echo$companyname ?>'   readonly class='form-control'/>
                      
                    </div>
                <div class='form-group'>
                        <label>Company Address</label>
                        <input type='text'  value='<?php echo$companyaddress ?>' name='company_address' readonly  class='form-control'/>
                </div>          
                
            </div>
        </div>
        <div class='row'>
             <div class='col-md-12'>
                <h5 class='text-info'>Product Details</h5>
                <table class='table table-bordered'>
                    <thead>
                        <tr  class="text-center"> 
                            <th>Product</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Total</th>
                            
                        </tr>
                    </thead>
                   
                        
     <?php
      $connection = mysqli_connect("localhost","root","");
      $db = mysqli_select_db($connection,"invoice_db");

      
      $sql = "SELECT * FROM purchase_product WHERE ID='{$_GET["view"]}'";

          
      $data = mysqli_query($connection,$sql);

          while($row = mysqli_fetch_array($data)){
                $pid=$row['ID'];
                 $p_name  = $row ['PRODUCT_NAME'];
                 $p_price  = $row["PRODUCT_PRICE"];
                 $stocks  = $row["item_qty"];
                 $total = ($p_price * $stocks);
          ?> <tbody id='product_tbody'>
          <tr  class="text-center">
                         <td ><?php echo$p_name ?> </td>
                         <td name='price'><?php echo$p_price ?> </td>
                         <td name='qty'><?php echo$stocks ?> </td>
                
               <td name='total'><?php echo$total ?></td>      
               <?php }?>      
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr >
                            <td class='text-right'>Total</td>
                            
                            <td><input type='text' value=<?php echo$grand_total ?>  readonly class='form-control ' /> </td>

                        </tr> 
                    </tfoot>
                </table>
            </div>
        </div>
    </form>
 <script>
   $("body").on("keyup",".price",function(){
            var price= Number($(this).val());
            var qty = Number($(this).closest("tr").find(".qty").val());
            $(this).closest("tr").find(".total".val(price*qty));
            
        });

        $("body").on("keyup",".qty",function(){
            var qty = Number($(this).val());
            var price =Number($(this).closest("tr").find(".price").val());
            $(this).closest("tr").find(".total").val(price*qty);
           
        });

 </script>

