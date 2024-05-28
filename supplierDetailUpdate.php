<?php
$connection = mysqli_connect("localhost", "root", "", "invoice_db");
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

if (isset($_GET["update"])) {
    $sql = "SELECT * FROM supplier_list WHERE supplier_id='{$_GET["update"]}'";
    $data = mysqli_query($connection, $sql);

    if ($row = mysqli_fetch_array($data)) {
        $company_id=$row['supplier_id'];
        $company_name  = $row ['company_name'];
        $contact  = $row["contact"];
        $addressString  = $row["company_address"];
        $company_address = explode(', ', $addressString);

        $address = isset($company_address[0]) ? $company_address[0] : '';
        $city = isset($company_address[1]) ? $company_address[1] : '';
        $state = isset($company_address[2]) ? $company_address[2] : '';
        $country = isset($company_address[3]) ? $company_address[3] : '';
        $pincode = isset($company_address[4]) ? $company_address[4] : '';
       
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $company_name = mysqli_real_escape_string($connection, $_POST['company_name']);
    $company_address = mysqli_real_escape_string($connection, $_POST['company_address']);
    $contact = mysqli_real_escape_string($connection, $_POST['contact']);

// City ID used get City name
    $c_city = mysqli_real_escape_string($connection, $_POST['city']);
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

    $company_add = $company_address . ', ' .$city_value . ', ' . $state_value . ', ' . $country_value . ', ' . $c_pincode;

    $sql = "UPDATE supplier_list SET company_name = '$company_name', company_address = '$company_add', contact = '$contact' WHERE supplier_id = $company_id";
    if (mysqli_query($connection, $sql)) {
        echo '<script> location.replace ("supplierList.php")</script>';
       
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
        <!-- CSS -->
        <link rel="stylesheet" href="style.css">
</head>
<body>
   
    <div class="updatecustomer_page">
        <div class="container">
            <h3 class="text-warning font-monospace">Update Customer Details</h3>
            <form method='post' action='supplierDetailUpdate.php?update=<?php echo $_GET["update"]; ?>'>
                <div class="form-row">
                    <div class="form-group">
                        <label for="inputName">Company Name</label>
                        <input type="text" name="company_name" value="<?php echo $company_name ?>" class="form-control" id="inputName" placeholder="Enter Name">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputAddress">Company Address</label>
                    <input type="text" name="company_address" value="<?php echo $address ?>" class="form-control" id="inputAddress" placeholder="Address">
                </div>
                <div class="form-group">
                    <label for="inputNumber">Contact</label>
                    <input type="text" name="contact" value="<?php echo $contact ?>" class="form-control" id="inputNumber" placeholder="Enter Mobile Number">
                </div>
                <div class="form-group">
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
                <div class="form-group">
                    <label for="state">State</label>
                    <select class="form-select" id="state" name="state">
                        <option value="" selected disabled><?php echo $state ?></option>
                    </select>
                </div>
                <label for="city">City</label>
                <div class="form-group  d-flex">
                   
                    <select class="form-select" id="city" name="city">
                        <option value='' selected disabled><?php echo $city ?> </option>
                    </select>
                
                    <label for="pincode" class="mx-2">Pincode</label>
                    <input type="text" value='<?php echo $pincode ?>' class="form-control mx-2" name="pincode" id="pincode"/>
                </div>
                <div class=' d-flex justify-content-between'>
                <button type="button" class="btn btn-danger text-center mt-4 "><a class='text-decoration-none text-dark' href='customerDeatails.php'>Cancel</a></button>

                <button type="submit" name="submit" class="btn btn-warning mt-4 text-center">UPDATE</button>

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
