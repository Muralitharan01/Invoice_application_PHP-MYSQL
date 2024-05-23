<?php
$conn = mysqli_connect('localhost','root','','invoice_db');
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get the form data
  $c_name = $_POST['customer_name'];
  $c_address = $_POST['customer_address'];
  $c_number = $_POST['customer_number'];

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

  $customer_city= $city_value . ', ' . $state_value . ', ' . $country_value .','. $c_pincode ;

  // Insert data into the database
  $sql = "INSERT INTO add_customer(CUSNAME,CUSADDRESS,CUSCITY,CUSMOBILE) 
  VALUES ('$c_name', '$c_address','$customer_city', '$c_number')";

  if ($conn->query($sql) === TRUE) {
    echo "<div class='alert alert-info text-center'>New Customer Addeed successfully   see<a href='customerDeatails.php'>Customer List</a></div>";

  } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
  }
};

include 'include_common/header.php' ?>

  <div class="d-flex justify-content-center align-items-center">
    <div class="container ">
      <h3 class="text-start ">Add Customer</h3>
      <form method='post' action='addcustomer.php'>

        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="inputName">Name</label>
            <input type="text" name="customer_name" class="form-control" id="inputName" placeholder="Enter Name">
          </div>

        </div>
        <div class="form-group col-md-6">
          <label for="inputAddress">Address</label>
          <input type="text" name="customer_address" class="form-control" id="inputAddress" placeholder="Address">
        </div>
        <div class="form-group col-md-6">
          <label for="inputNumber">Mobile Number</label>
          <input type="text" name="customer_number" class="form-control" id="inputNumber" placeholder="Enter Mobile Number">
        </div>
                <div class="form-group col-md-6">
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
                <div class="form-group col-md-6">
                 <label for="state">State</label>
                    <select class="form-select" id="state" name='state'>
                        <option value="" selected disabled>Select State</option>
                    </select>
                </div>
                <label for="city">City</label>
                <div class="form-group col-md-6 d-flex">
                 
                    <select class="form-select" id="city" name="city">
                        <option value="" selected disabled>Select City</option>
                    </select>
                    
                    
                    <label for="pincode" class='mx-2'>Pincode</label>
                    <input type="text"  class='form-control mx-2' name='pincode' value=""  id='pincode'/>
                    </select>

                                </div>
                
                                <button type="submit" class="btn btn-primary mt-4 ">ADD</button>

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