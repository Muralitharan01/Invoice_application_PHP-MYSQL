<?php
session_start();

include 'include_common/header.php'; 
?>
<div class='container pt-2'>
    <h3 class='text-center text-success font-weight-bold'>INVOICE</h3>
    <?php
    $con = mysqli_connect("localhost", "root", "", "invoice_db");

    if (isset($_POST["submit"])) {
        $invoice_no = $_POST["invoice_no"];
        $invoice_date = date("y-m-d", strtotime($_POST["invoice_date"]));
        $cname = mysqli_real_escape_string($con, $_POST["cname"]);
        $caddress = mysqli_real_escape_string($con, $_POST["caddress"]);
        $ccity = mysqli_real_escape_string($con, $_POST["ccity"]);
        $mobile_no = mysqli_real_escape_string($con, (string)$_POST['cmobile']);
        $grand_total = mysqli_real_escape_string($con, $_POST["grand_total"]);

        $sql = "INSERT INTO invoice (INVOICE_NO, INVOICE_DATE, CNAME, ADDRESS, CITY, MOBILE_NO, GRAND_TOTAL)
                VALUES ('{$invoice_no}', '{$invoice_date}', '{$cname}', '{$caddress}', '{$ccity}', '{$mobile_no}', '{$grand_total}')";

        if ($con->query($sql)) {
            $sid = $con->insert_id;
            $rows = [];
            $product_error=[];
            $result=[];
            // $stocks_update_query=[];

            for ($i = 0; $i < count($_POST['pname']); $i++) {
                $pname = mysqli_real_escape_string($con, $_POST["pname"][$i]);
                $price = mysqli_real_escape_string($con, $_POST["price"][$i]);
                $qty = mysqli_real_escape_string($con, $_POST["qty"][$i]);
                $total = mysqli_real_escape_string($con, $_POST["total"][$i]);

                $product_check_sql = "SELECT * FROM product_list WHERE PRODUCT_NAME = '$pname'";
                $product_result = mysqli_query($con, $product_check_sql);

                if ($product_result && mysqli_num_rows($product_result) > 0) {
                    $product_row = mysqli_fetch_assoc($product_result);
                    $product_stock_qty = $product_row['item_qty'];

                    if ($product_stock_qty >= $qty) {
                        $rows[] = "('{$sid}', '{$pname}', '{$price}', '{$qty}', '{$total}')";
                        $stocks_update_query = "UPDATE product_list SET item_qty = item_qty-{$qty} WHERE PRODUCT_NAME = '$pname'";
               $result[] =$con->query($stocks_update_query);
                    } else {
                        echo "<div class='alert alert-warning text-center'>Insufficient stock for product: $pname</div>";
                        $product_error = true;
                        break;
                    }
                } else {
                    echo "<div class='alert alert-danger text-center'>Product not found: $pname</div>";
                    $product_error = true;
                    break;
                }
            }

            if (!$product_error) {
                $sql2 = "INSERT INTO invoice_product (SID, PNAME, PRICE, QTY, TOTAL) VALUES " . implode(",", $rows);
                
                if ($con->query($sql2)) {
                    echo "<div class='alert alert-success'>Invoice Added. <a href='print.php?id={$sid}' target='_BLANK'>Click to print</a></div>";
                } else {
                    echo "<div class='alert alert-danger'>Invoice Addition Failed</div>";
                }
            }
        } else {
            echo "<div class='alert alert-danger'>Invoice Addition Failed</div>";
        }
    }
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
                    <input type='text' name='invoice_date' id='date' required class='form-control'/>
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
                    <label>Address</label>
                    <input type='text' id='customer_address' name='caddress' required class='form-control'/>
                </div>
                <div class='form-group'>
                    <label>City</label>
                    <input type='text' id='customer_city' name='ccity' required class='form-control'/>
                </div>
                <div class='form-group'>
                    <label>Mobile No</label>
                    <input type='text' id='customer_mobile' name='cmobile' required class='form-control'/>
                </div>
            </div>
        </div>
        <div class='row'>
            <div class='col-md-12'>
                <h5 class='text-success'>Product Details</h5>
                <table class='table table-bordered'>
                    <thead>
                        <tr class='text-center'>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id='product_tbody'>
                        <tr class='text-center'>
                            <td class='col-md-6'>
                                <input type='text' name='pname[]' id='productname' class='form-control autocomplete' required/>
                                <div id='suggestions'></div>
                            </td>
                            <td><input type='text' name='price[]' id='price' class='form-control price' readonly required/></td>
                            <td><input type='text' name='qty[]' class='form-control qty' required/></td>
                            <td><input type='text' name='total[]' class='form-control total' required/></td>
                            <td><input type='button' value='X' class='btn btn-danger btn-sm btn-row-remove'/></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td><input type='button' value='+ Add Row' class='btn btn-primary btn-sm' id='btn-add-row'/></td>
                            <td colspan='2' class='text-right'>Total</td>
                            <td><input type='text' id='grand_total' name='grand_total' class='form-control'/></td>
                        </tr>
                    </tfoot>
                </table>
                <input type='submit' name='submit' value='Save' class='btn btn-success float-right'/>
            </div>
        </div>
    </form>
</div>
<!-- Jquery Script CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){
       
        $("#date").datepicker({
          dateFormat:"dd-mm-yy"
        });
 
        $("#btn-add-row").click(function(){
          var row="<tr class='text-center'> <td><input type='text' id='productname' required name='pname[]' class='form-control autocomplete'><div id='suggestions'></div></td><td><input type='text' id='price' required name='price[]' class='form-control price'></td> <td><input type='text' required name='qty[]' class='form-control qty'></td> <td><input type='text' required name='total[]' class='form-control total'></td> <td><input type='button' value='x' class='btn btn-danger btn-sm btn-row-remove'> </td> </tr>";
          
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
                    $('#suggestions').function(data)
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
    
    <?php include 'include_common/footer.php' ?>