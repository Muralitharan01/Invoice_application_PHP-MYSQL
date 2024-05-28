<?php
        $connection = mysqli_connect("localhost","root","");
        $db = mysqli_select_db($connection,"invoice_db");
    
        $sql = "delete from supplier_list where supplier_id ='{$_GET["supplierdel"]}'";


        if(mysqli_query($connection,$sql)){
            echo '<script> location.replace("supplierList.php") </script>';
        }else{
            echo"some thing Error" .$connection->error;
        }


?>