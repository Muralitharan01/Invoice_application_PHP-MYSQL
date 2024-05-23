<?php
$connection = mysqli_connect("localhost", "root", "", "invoice_db");
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

if (isset($_GET["update"])) {
    $sql = "SELECT * FROM add_customer WHERE ID='{$_GET["update"]}'";
    $data = mysqli_query($connection, $sql);

    if ($row = mysqli_fetch_array($data)) {
        $sid = $row['ID'];
        $name = $row['CUSNAME'];
        $address = $row["CUSADDRESS"];
        $cityString = $row['CUSCITY'];
        $cityArray = explode(', ', $cityString);

        $city = isset($cityArray[0]) ? $cityArray[0] : '';
        $state = isset($cityArray[1]) ? $cityArray[1] : '';
        $country = isset($cityArray[2]) ? $cityArray[2] : '';
        $pincode = isset($cityArray[3]) ? $cityArray[3] : '';

        $mobile = $row['CUSMOBILE'];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $c_name = mysqli_real_escape_string($connection, $_POST['customer_name']);
    $c_address = mysqli_real_escape_string($connection, $_POST['customer_address']);
    $c_number = mysqli_real_escape_string($connection, $_POST['customer_number']);
    $c_city = mysqli_real_escape_string($connection, $_POST['city']);
// City ID used get City name
    $city_query = "SELECT * FROM table_name WHERE city_id = $c_city";
    $city_result = mysqli_query($connection, $city_query);
    $city_data = mysqli_fetch_assoc($city_result);
    $city_value = $city_data['PostOfficeName'];

// State ID used get State name

    $c_state = mysqli_real_escape_string($connection, $_POST['state']);

    $state_query = "SELECT * FROM states WHERE id = $c_state";
    $state_result = mysqli_query($connection, $state_query);
    $state_data = mysqli_fetch_assoc($state_result);
    $state_value = $state_data['name'];

// Country ID used get country name
    
    $c_country = mysqli_real_escape_string($connection, $_POST['country']);

    $country_query = "SELECT * FROM countries WHERE id = $c_country";
    $country_result = mysqli_query($connection, $country_query);
    $country_data = mysqli_fetch_assoc($country_result);
    $country_value = $country_data['name'];

    $c_pincode = mysqli_real_escape_string($connection, $_POST['pincode']);

    $customer_city = $city_value . ', ' . $state_value . ', ' . $country_value . ', ' . $c_pincode;

    $sql = "UPDATE add_customer SET CUSNAME = '$c_name', CUSADDRESS = '$c_address', CUSCITY = '$customer_city', CUSMOBILE = '$c_number' WHERE ID = $sid";
    if (mysqli_query($connection, $sql)) {
        echo '<script> location.replace ("customerDeatails.php")</script>';
       
    } else {
        echo "Error updating record: " . mysqli_error($connection);
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <title>Update Customer Details</title>
</head>
<body>
    <div>
        <button class="btn btn-success btn-lg float-right mt-2 mb-2 pl-6">
            <a href="index.php" class="text-light text-decoration-none border border-success">Create New Bill</a>
        </button>
        
    </div>
    <div class="d-flex justify-content-center align-items-center">
        <div class="container">
            <h3 class="text-start">Update Customer Details</h3>
            <form method='post' action='updatecustomer.php?update=<?php echo $_GET["update"]; ?>'>
                <div class="form-row">
                    <div class="form-group col-md-8">
                        <label for="inputName">Name</label>
                        <input type="text" name="customer_name" value="<?php echo $name ?>" class="form-control" id="inputName" placeholder="Enter Name">
                    </div>
                </div>
                <div class="form-group col-md-8">
                    <label for="inputAddress">Address</label>
                    <input type="text" name="customer_address" value="<?php echo $address ?>" class="form-control" id="inputAddress" placeholder="Address">
                </div>
                <div class="form-group col-md-8">
                    <label for="inputNumber">Mobile Number</label>
                    <input type="text" name="customer_number" value="<?php echo $mobile ?>" class="form-control" id="inputNumber" placeholder="Enter Mobile Number">
                </div>
                <div class="form-group col-md-8">
                    <label for="country">Country</label>
                    <select class="form-select" id="country" name="country">
                        <option value="" selected disabled><?php echo $country ?></option>
                        <?php
                        $country_query = "SELECT * FROM countries";
                        $country_result = mysqli_query($connection, $country_query);
                        while ($row = mysqli_fetch_assoc($country_result)) {
                            echo "<option value='{$row['id']}'>{$row['name']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-8">
                    <label for="state">State</label>
                    <select class="form-select" id="state" name="state">
                        <option value="" selected disabled><?php echo $state ?></option>
                    </select>
                </div>
                <label for="city">City</label>
                <div class="form-group  col-md-8 d-flex">
                   
                    <select class="form-select" id="city" name="city">
                        <option value='' selected disabled><?php echo $city ?> </option>
                    </select>
                
                    <label for="pincode" class="mx-2">Pincode</label>
                    <input type="text" value='<?php echo $pincode ?>' class="form-control mx-2" name="pincode" id="pincode"/>
                </div>
                <div class='form-group  '>

                <button type="submit" name="submit" class="btn btn-warning mt-4 col-md-4 text-center">UPDATE</button>

                </div>
            </form>
        </div>
    </div>

    <script>
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
            });
        });

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
            });
        });

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
            });
        });
    </script>
</body>
</html>
