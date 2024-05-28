<?php
// Start the session
session_start();
?>
<?php
    $conn = mysqli_connect('localhost','root','','invoice_db');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
            }

        // Check if form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Get the form data
                $name = $_POST['name'];
                $username = $_POST['username'];
                $email = $_POST['email'];
                $number = $_POST['number'];
                $password = $_POST['password'];


                $sql = "SELECT * FROM register_user WHERE EMAIL='$email'";
                $result = mysqli_query($conn,$sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $exicitinguser = $row['EMAIL'];
                    echo "<div class='alert alert-danger text-center'>This Email Already Register</div>";
                }else{

                
            if(empty($name) || empty($username) ||empty($email) ||empty($number) ||empty($password)){
                echo "<div class='alert alert-warning text-center'>All fields are Required </div>";

                    }else{
                        // Hash the password
                        // $hashed_pass = password_hash($password, PASSWORD_DEFAULT);

                            // Insert data into the database
                            $register_sql = "INSERT INTO register_user(NAME,USERNAME,EMAIL,NUMBER,PASSWORD) 
                            VALUES ('$name', '$username','$email', '$number','$password')";
 
                        if ($conn->query($register_sql) === TRUE) {

                                    $_SESSION['username'] = $username;
                                    $_SESSION['email'] = $email;
                                    echo "<div class='alert alert-info text-center'>Register Succefully successfully</div>";
                                    header("Location:Login.php?");
                        } else {
                            echo "Error: " . $sql . "<br>" . $conn->error;
                        } }};
                    }
  ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!-- Bootstrap CSS -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
   
    <title>Register</title>

    <link rel="stylesheet" href="style.css">

</head>
<body>
    <form action="Register.php" method="post" class='register_page container mt-4'>
        <h2 class='text-center'>Register</h2>
       <div class='form-group '>
            <label for='inputname'>Name</label>
                <input type='text' name='name' id='inputname' class='form-control'  placeholder='Enter Your Name'/>
        </div>
        <div class='form-group '>
            <label for='inputusername'>UserName</label>
                <input type='text' name='username' id='inputusername' class='form-control'  placeholder='Enter User Name'/>
        </div><div class='form-group '>
            <label for='inputemail'>Email</label>
                <input type='email' name='email' id='inputemail' class='form-control'  placeholder='Enter Your Email'/>
        </div><div class='form-group '>
            <label for='inputnumber'>Number</label>
                <input type='text' name='number' id='inputnumber' class='form-control'  placeholder='Enter Your MobileNumber'/>
        </div><div class='form-group '>
            <label for='inputpassword'>Password</label>
                <input type='password' name='password' id='inputpassword' class='form-control'  placeholder='Enter Password'/>
                <input type="submit" value="Register" class='btn btn-info float-right mt-2'>
        
            </div>
            <a href='Login.php'>Existing User ? Login here</a>
    </form>
    
</body>
</html>