<?php
session_start();
include 'include_common/header.php';
?>
<div class='container pt-2'>
    <h3 class='text-center text-success font-weight-bold '>Purchase Inward</h3>
    <?php
    $con = mysqli_connect("localhost", "root", "", "invoice_db");

    if (isset($_POST["submit"])) {
        $bill_no = $_POST["bill_no"];
        $bill_date = date("y-m-d", strtotime($_POST["bill_date"]));
        $company_name = mysqli_real_escape_string($con, $_POST["company_name"]);
        $company_address = mysqli_real_escape_string($con, $_POST["company_address"]);
        $contact = mysqli_real_escape_string($con, (string)$_POST['contact']);
        $grand_total = mysqli_real_escape_string($con, $_POST["grand_total"]);
        $company_add = $company_address . ', ' . $contact;

        $sql = "INSERT INTO purchase_bill (BILL_NO, BILL_DATE, COMPANYNAME, COMPANYADDRESS, GRAND_TOTAL)
                VALUES ('{$bill_no}', '{$bill_date}', '{$company_name}', '{$company_add}', '{$grand_total}')";

        if ($con->query($sql)) {
            $sid = $con->insert_id;

            $rows = [];
            for ($i = 0; $i < count($_POST['pname']); $i++) {
                $pname = mysqli_real_escape_string($con, $_POST["pname"][$i]);
                $price = mysqli_real_escape_string($con, $_POST["price"][$i]);
                $qty = mysqli_real_escape_string($con, $_POST["qty"][$i]);
                $total = mysqli_real_escape_string($con, $_POST["total"][$i]);

                $rows[] = "('{$sid}', '{$pname}', '{$price}', '{$qty}')";

                $stocks_update_query = "UPDATE product_list SET item_qty = item_qty + {$qty} WHERE PRODUCT_NAME = '{$pname}'";
                if (!mysqli_query($con, $stocks_update_query)) {
                    echo "Error updating record: " . mysqli_error($con);
                }
                $price_update_query = "UPDATE product_list SET PRODUCT_PRICE = $price WHERE PRODUCT_NAME = '{$pname}'";
                if (!mysqli_query($con, $price_update_query)) {
                    echo "Error updating record: " . mysqli_error($con);
                }
            }

            $sql2 = "INSERT INTO Purchase_Product (ID, PRODUCT_NAME, PRODUCT_PRICE, item_qty) VALUES " . implode(",", $rows);
            if ($con->query($sql2)) {
                echo "<div class='alert alert-success'>Purchase Bill Added <a href='purchaseDetails.php'>Click</a></div>";
            } else {
                echo "<div class='alert alert-danger'>Bill Addition Failed</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Bill Addition Failed</div>";
        }
    }
    ?>
    <form method='post' action='purchaseBill.php' autocomplete='off'>
        <div class='row'>
            <div class='col-md-4'>
                <h5 class='text-success'>Bill Details</h5>
                <div class='form-group'>
                        <label>Bill NO</label>
                        <input type='text' name='bill_no' required class='form-control'/>
                </div>
                <div class='form-group'>
                        <label>Bill Date</label>
                        <input type='text' name='bill_date' id='bill_date' required  class='form-control'/>
                </div>
            </div>
            <div class='col-md-8'>
                <h5 class='text-success'>Supplier Details</h5>
                <div class='form-group'>
                        <label>Company Name</label>
                        <input type='text' id='company_name' name='company_name' required class='form-control'/>
                       <div id='supplierdatashow'></div>
                    </div>
                <div class='form-group'>
                        <label>Company Name</label>
                        <input type='text' id='company_address' name='company_address' required  class='form-control'/>
                </div>          
                <div class='form-group'>
                        <label>Mobile No</label>
                        <input type='text' id='contact' name='contact' required  class='form-control'/>
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
                            <td><input type='text' id='price' required name='price[]' class='form-control price' /></td>
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
   <!-- Jquery Script CDN -->
   <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

   <script>

    
    $(document).ready(function(){
       
        $("#bill_date").datepicker({
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
// SUPPLIER DETAILS HANDLING
$(document).ready(function() {
    $('#company_name').on('input', function() {
        var query = $(this).val();
        if (query.length > 0) {
            $.ajax({
                url: 'ajax/getsupplier.php',
                method: 'POST',
                data: {query: query},
                success: function(data) {
                    $('#supplierdatashow').html(data);
                }
            });
        } else {
            $('#supplierdatashow').html('');
        }
    });

    $(document).on('click', '#supplierdatashow div', function() {
        var companyname = $(this).data('company_name');
        var companyaddress = $(this).data('company_address');
        var contact = $(this).data('contact');

       
        $('#company_address').val(companyaddress);
        $('#contact').val(contact);

        
       $('#supplierdatashow').html('');
      
        $('#company_name').val(companyname);
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