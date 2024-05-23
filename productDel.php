<?php
        $connection = mysqli_connect("localhost","root","");
        $db = mysqli_select_db($connection,"invoice_db");
    
        $sql = "delete from product_list where PRODUCT_ID ='{$_GET["pdel"]}'";


        if(mysqli_query($connection,$sql)){
            echo '<script> location.replace ("productlist.php")</script>';
        }else{
            echo"some thing Error" .$connection->error;
        }


?>