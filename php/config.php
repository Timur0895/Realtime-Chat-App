<?php
    $hostname = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "chat";

    $conn = mysqli_connect($hostname, $username, $password, $dbname);
    if(!$conn){
        echo "OKay" . mysqli_connect_error();
    };


?>