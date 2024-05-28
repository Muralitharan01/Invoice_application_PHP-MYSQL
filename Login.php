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
        $username = $_POST['username'];
        $password = $_POST['password'];

            if( empty($username) ||empty($password)){
                echo "<div class='alert alert-warning text-center'>All fields are Required </div>";
                 }else{
                        $check_sql = "SELECT * FROM register_user WHERE USERNAME = '$username'";
                        $result = $conn->query($check_sql);
                    
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $hashed_pass = $row['PASSWORD'];
                            $userid = $row['USER_ID'];


                   if ($password == $hashed_pass) {
                                    $_SESSION['username'] = $username;
                                    $_SESSION['userid'] = $userid;
                                
                                    echo "<div class='alert alert-info text-center'>Login successful</div>";
                                    header("Location:LoginuserDetail.php?");
                                    } else {
                                        echo "<div class='alert alert-danger text-center'>Invalid password</div>";
                                    }
                        } else {
                            echo "<div class='alert alert-danger text-center'>No user found with that username</div>";
                        }
            }
};
  ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
         <!-- Bootstrap CSS -->
         <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
   
    <title>Login</title>

    <link rel="stylesheet" href="style.css">
</head>
<body>

     <form action="Login.php" method="post" class='register_page container mt-8'>
        <h2 class='text-center'>Login</h2>
      
        <div class='form-group '>
            <label for='inputusername'>UserName</label>
                <input type='text' name='username' id='inputusername' class='form-control'  placeholder='Enter User Name'/>
        </div><div class='form-group '>
            <label for='inputpassword'>Password</label>
                <input type='password' name='password' id='inputpassword' class='form-control'  placeholder='Enter Password'/>
                <input type="submit" value="Login" class='btn btn-info float-right mt-2'>
        
            </div>
            <a href='Register.php'>New user? Register Here </a>
    </form>
</body>
</html>