<?php
//connect with DB
$conn = mysqli_connect("localhost", "root", "", "hd36");

//check the connection  
if (mysqli_connect_errno()) {
    echo "faild to connect with database!" . $conn->connect_errno;
    die("retry");
}