<?php session_start();
$conn = mysqli_connect('localhost','root','','invoice_db');
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get the form data
  $company_name = $_POST['company_name'];
  $company_address = $_POST['company_address'];
  $company_contact = $_POST['company_number'];

  $c_city =   $_POST['city'];

  $city = "SELECT * FROM table_name WHERE city_id =$c_city";
  $city_qry = mysqli_query($conn, $city);
  $city_datas = mysqli_fetch_assoc($city_qry);
  $city_value= $city_datas['PostOfficeName']; 


   $c_state =   $_POST['state'];


  $state = "SELECT * FROM states WHERE id =$c_state";
  $state_qry = mysqli_query($conn, $state);
  $state_datas = mysqli_fetch_assoc($state_qry);
  $state_value= $state_datas['name']; 

  
  $c_country = $_POST['country'];


  $country = "SELECT * FROM countries WHERE id =$c_country";
$country_qry = mysqli_query($conn, $country);
$country_datas = mysqli_fetch_assoc($country_qry);
$country_value= $country_datas['name']; 

  $c_pincode = $_POST['pincode'];

  $company_details= $company_address . ', '.$city_value . ', ' . $state_value . ', ' . $country_value .','. $c_pincode ;

  // Insert data into the database
  $sql = "INSERT INTO supplier_list(company_name,company_address,contact) 
  VALUES ('$company_name','$company_details', '$company_contact')";

  if ($conn->query($sql) === TRUE) {
    echo "<div class='alert alert-info text-center'>New Supplier Addeed successfully   see<a href='SupplierList.php'>Supplier List</a></div>";

  } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
  }
};

include 'include_common/header.php' ?>
    
  <div class="addsupplier_page mt-4">
    <div class=" ">
      <h3 class="text-center font-monospace ">Add Supplier Detail</h3>
      <form method='post' action='addsupplier.php'>

        <div class="form-row">
        
          <div class="form-group col-md-12 ">
            <label for="inputName">Company Name</label>
            <input type="text" name="company_name" class="form-control" id="inputName" placeholder="Enter Company Name">
          </div>

        </div>
        <div class="form-group  ">
          <label for="inputAddress">Company Address</label>
          <input type="text" name="company_address" class="form-control" id="inputAddress" placeholder="Address">
        </div>
        <div class="form-group ">
          <label for="inputNumber">Contact</label>
          <input type="text" name="company_number" class="form-control" id="inputNumber" placeholder="Enter Mobile Number">
        </div>
                <div class="form-group ">
                 <label for="country">Country</label>
                            <select class="form-select" id="country" name="country">
                                <option value="" selected disabled>Select Country</option>
                                <?php
                                $conn = mysqli_connect('localhost','root','','invoice_db');
                                $country = "SELECT * FROM countries";
                                $county_qry = mysqli_query($conn, $country);
                                
                                
                                
                                while ($row = mysqli_fetch_assoc($county_qry)) : ?>
                                    <option value="<?php echo $row['id']; ?>"> <?php echo $row['name']; ?> </option>
                                <?php endwhile; ?>
                            </select>                           
                </div>
                <div class="form-group ">
                 <label for="state">State</label>
                    <select class="form-select" id="state" name='state'>
                        <option value="" selected disabled>Select State</option>
                    </select>
                </div>
                <label for="city">City</label>
                <div class="form-group  d-flex">
                 
                    <select class="form-select" id="city" name="city">
                        <option value="" selected disabled>Select City</option>
                    </select>
                    
                    
                    <label for="pincode" class='mx-2'>Pincode</label>
                    <input type="text"  class='form-control mx-2' name='pincode' value=""  id='pincode'/>
                    </select>

                                </div>
                
                                <button type="submit" class="btn btn-primary mt-4 ">ADD Supplier</button>

        </div>
              
      </form>

    </div>
    
  </div>


  <?php include 'include_common/footer.php' ?>

<script>

  // GET COUNTRY,STATE,CITY WITH PINCODE USING AJAX
    // County State

    $('#country').on('change', function() {
        var country_id = this.value;
        $.ajax({
            url: 'ajax/state.php',
            type: "POST",
            data: {
                country_data: country_id
            },
            success: function(result) {
                $('#state').html(result);
            }
        })
    });
    // state city
    $('#state').on('change', function() {
        var state_id = this.value;
        $.ajax({
            url: 'ajax/city.php',
            type: "POST",
            data: {
                state_data: state_id
            },
            success: function(data) {
                $('#city').html(data);
                

            }
        })
    });
// Pincode
    $('#city').on('change', function() {
        var city_id = this.value;
        $.ajax({
            url: 'ajax/pincode.php',
            type: "POST",
            data: {
                city_data: city_id
            },
            success: function(data) {
               
                $('#pincode').val(data);

            }
        })
    });
</script>