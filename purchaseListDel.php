<?php 
    $connection = mysqli_connect("localhost","root","");
    $db = mysqli_select_db($connection,"invoice_db");

        $sql = "delete from purchase_bill where purchse_ID ='{$_GET["del"]}'";


        if(mysqli_query($connection,$sql)){
            echo '<script> location.replace ("purchaseDetails.php")</script>';
        }else{
            echo"some thing Error" .$connection->error;
        }

?>
