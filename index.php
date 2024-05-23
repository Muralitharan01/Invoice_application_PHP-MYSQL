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
   
    <link rel="stylesheet" href="style.css">

</head>
<body>
<header>
        <nav>
            <div class="menu-toggle" id="menu-toggle">
                ☰
            </div>
            <ul id="menu" class="menu text-center">
                <li><a href="invoiceDetails.php">Invoice List</a></li>
                <li><a href="customerDeatails.php">Customer List</a></li>
                <li><a href="productlist.php">Product List</a></li>
                <li><a href="addcustomer.php">Add Customer </a></li>
                <li><a href="addProduct.php">Add Product</a></li>   
            </ul>
        </nav>
    </header>   <div class='container pt-2'>
    <h3 class='text-center text-success font-weight-bold '>INVOICE</h3>
    <?php
     $con=mysqli_connect("localhost","root","","invoice_db");

     if(isset($_POST{"submit"})){
         $invoice_no = $_POST["invoice_no"];
        $invoice_date=date("y-m-d",strtotime($_POST["invoice_date"]));
        $cname =mysqli_real_escape_string($con,$_POST["cname"]);
        $caddress=mysqli_real_escape_string($con,$_POST["caddress"]);
        $ccity =mysqli_real_escape_string($con,$_POST["ccity"]);
        $mobile_no = mysqli_real_escape_string($con, (string)$_POST['cmobile']);
        $grand_total =mysqli_real_escape_string($con,$_POST["grand_total"]);
        
         $sql = "insert into invoice(INVOICE_NO,INVOICE_DATE,CNAME,ADDRESS,CITY,MOBILE_NO,GRAND_TOTAL)
          values('{$invoice_no}','{$invoice_date}','{$cname}','{$caddress}','{$ccity}','{$mobile_no}','{$grand_total}')";
          
          if($con->query($sql)){
            $sid=$con->insert_id;

            $sql2 = "insert into invoice_product(SID,PNAME,PRICE,QTY,TOTAL)
            values";
            $row=[];
            for($i=0;$i<count($_POST['pname']);$i++){
                $pname=mysqli_real_escape_string($con,$_POST["pname"][$i]);
                $price=mysqli_real_escape_string($con,$_POST["price"][$i]);
                $qty=mysqli_real_escape_string($con,$_POST["qty"][$i]);
                $total=mysqli_real_escape_string($con,$_POST["total"][$i]);

                $rows[]="('{$sid}','{$pname}','{$price}','{$qty}','{$total}')";
            }
          $sql2.=implode(",",$rows);
          if($con->query($sql2)){
            echo"<div class='alert alert-success'>invoice Added<a href='print.php?id={$sid} target='_BLANK''>Click</a></div>";
          }else{
            echo"<div class='alert alert-danger'>invoice Added Fail</div>";

          }
          }
          else{
            echo"<div class='alert alert-danger'>invoice Added Fail</div>";

          }

     };

    ?>
    <form method='post' action='index.php' autocomplete='off'>
        <div class='row'>
            <div class='col-md-4'>
                <h5 class='text-success'>Invoice Details</h5>
                <div class='form-group'>
                        <label>Invoice NO</label>
                        <input type='text' name='invoice_no' required class='form-control'/>
                </div>
                <div class='form-group'>
                        <label>Invoice Date</label>
                        <input type='text' name='invoice_date' id='date' required  class='form-control'/>
                </div>
            </div>
            <div class='col-md-8'>
                <h5 class='text-success'>Customer Details</h5>
                <div class='form-group'>
                        <label>Name</label>
                        <input type='text' id='customer_name' name='cname' required class='form-control'/>
                       <div id='customerdatashow'></div>
                    </div>
                <div class='form-group'>
                        <label>Adress</label>
                        <input type='text' id='customer_address' name='caddress' required  class='form-control'/>
                </div>
                <div class='form-group'>
                        <label>City</label>
                        <input type='text' id='customer_city' name='ccity' required  class='form-control'/>
                </div>
                <div class='form-group'>
                        <label>Mobile No</label>
                        <input type='text' id='customer_mobile' name='cmobile' required  class='form-control'/>
                </div>
            </div>
        </div>
        <div class='row'>
             <div class='col-md-12'>
                <h5 class='text success'>Product Details</h5>
                <table class='table table-bordered'>
                    <thead>
                        <tr  class="text-center"> 
                            <th>Product</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id='product_tbody'>
                        <tr  class="text-center">
                            <td class='col-md-6'><input type='text' id='productname' required name='pname[]' class='form-control autocomplete' />
                        <div id="suggestions"></div>
                            </td>
                            <td><input type='text' id='price' required name='price[]' class='form-control price' readonly/></td>
                            <td><input type='text' required name='qty[]' class='form-control qty'/></td>
                            <td><input type='text' required name='total[]' class='form-control total'/></td>
                            <td><input type='button' value='X' class='btn btn-danger btn-sm btn-row-remove'/></td>
                            
                        </tr>
                    </tbody>
                    <tfoot>
                   
                        <tr>
                            <td><input type='button' value="+  Add Row" class='btn btn-primary btn-sm' id='btn-add-row'/> </td>
                            <td colspan='2' class='text-right'>Total</td>
                            <td><input type='text' id='grand_total' name='grand_total' class='form-control' /> </td>

                        </tr> 
                    </tfoot>
                </table>
                <input type='submit' name='submit' value='Save' class='btn btn-success float-right'/>
            
            </div>
        </div>
    </form>
</div>
   <script>

document.addEventListener('DOMContentLoaded', function() {
    var menuToggle = document.getElementById('menu-toggle');
    var menu = document.getElementById('menu');

    menuToggle.addEventListener('click', function() {
        menu.classList.toggle('active');
    });
});

 
    
    $(document).ready(function(){
       
        $("#date").datepicker({
          dateFormat:"dd-mm-yy"
        });
 
        $("#btn-add-row").click(function(){
          var row="<tr class='text-center'> <td><input type='text' id='productname' required name='pname[]' class='form-control autocomplete'><div id='suggestions'></div></td><td><input type='text' id='price' required name='price[]' class='form-control price' readonly></td> <td><input type='text' required name='qty[]' class='form-control qty'></td> <td><input type='text' required name='total[]' class='form-control total'></td> <td><input type='button' value='x' class='btn btn-danger btn-sm btn-row-remove'> </td> </tr>";
          
          $("#product_tbody").append(row);

        });

        $("body").on("click",".btn-row-remove",function(){
            if(confirm("Are You Sure")){
                $(this).closest("tr").remove();
                grand_total();
            };
        });

        $("body").on("keyup",".price",function(){
            var price= Number($(this).val());
            var qty = Number($(this).closest("tr").find(".qty").val());
            $(this).closest("tr").find(".total".val(price*qty));
            grand_total();
        });

        $("body").on("keyup",".qty",function(){
            var qty = Number($(this).val());
            var price =Number($(this).closest("tr").find(".price").val());
            $(this).closest("tr").find(".total").val(price*qty);
            grand_total();
        });

        function grand_total(){
            var total=0;
            $(".total").each(function(){
                total +=Number($(this).val());
            })
            $("#grand_total").val(total);
        }

        
    
    });
// CUSTOMER DETAILS HANDLING
$(document).ready(function() {
    $('#customer_name').on('input', function() {
        var query = $(this).val();
        if (query.length > 0) {
            $.ajax({
                url: 'ajax/getcustomer.php',
                method: 'POST',
                data: {query: query},
                success: function(data) {
                    $('#customerdatashow').html(data);
                }
            });
        } else {
            $('#customerdatashow').html('');
        }
    });

    $(document).on('click', '#customerdatashow div', function() {
        var customername = $(this).data('customername');
        var customeraddress = $(this).data('customeraddress');
        var customercity = $(this).data('customercity');  
        var customermobile = $(this).data('customermobile');

       
        $('#customer_address').val(customeraddress);
        $('#customer_city').val(customercity);
        $('#customer_mobile').val(customermobile);

        
       $('#customerdatashow').html('');
      
        $('#customer_name').val(customername);
    });
});



    // PRODUCT  HANDING
    $(document).ready(function() {
    $('#productname').on('input', function() {
        var query = $(this).val();
        if (query.length > 0) {
            $.ajax({
                url: 'ajax/getproduct.php',
                method: 'POST',
                data: {query: query},
                success: function(data) {
                    $('#suggestions').html(data);
                }
            });
        } else {
            $('#suggestions').html('');
        }
    });

    $(document).on('click', '#suggestions div', function() {
        var productname = $(this).data('productname');
        var productprice = $(this).data('productprice');

       
        $('#price').val(productprice);
        
       $('#suggestions').html('');
      
        $('#productname').val(productname);
    });
});


    </script>
    
</body>
</html>