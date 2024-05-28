<?php
session_start();

        if (!isset($_SESSION['userid'])) {
            header("Location: Login.php");
            
             }

                $userid= htmlspecialchars($_SESSION['userid']) ;
                
                $connection = mysqli_connect("localhost","root","");
                $db = mysqli_select_db($connection,"invoice_db");

                $sql = "SELECT * FROM register_user WHERE USER_ID='$userid'";
                $data = mysqli_query($connection,$sql);

 include 'include_common/header.php'
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>
<body>
    <?php
          while($row = mysqli_fetch_array($data)){
                   $name  = $row ['NAME'];
                   $uname  = $row["USERNAME"];
                   $number =$row['NUMBER'];
        ?>                 
                <div class='profile  '>
                  <h2>Profile</h2>
                  <div>
                   <h4 >Name:<?php echo$name?></h4>
                   <h4>UserName:<?php echo$uname?></h4>
                   <h4 >Mobile Number:<?php echo$number?></h4>
          </div>
          <button type='button' class='btn btn-danger'><a class='text-dark text-decoration-none' href="logout.php">Logout</a></button>

                </div>
               <?php  }  ?>
</body>
</html>
