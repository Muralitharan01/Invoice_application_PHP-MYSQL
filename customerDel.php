<?php
        $connection = mysqli_connect("localhost","root","");
        $db = mysqli_select_db($connection,"invoice_db");
    
        $sql = "delete from add_customer where ID ='{$_GET["cusdel"]}'";


        if(mysqli_query($connection,$sql)){
            echo '<script> location.replace("customerDeatails.php") </script>';
        }else{
            echo"some thing Error" .$connection->error;
        }


?>