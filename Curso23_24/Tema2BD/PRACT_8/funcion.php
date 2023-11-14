<?php

$con = mysqli_connect("localhost","my_user","my_passwd","my_db");


if(mysqli_connect_errno()){
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}


mysqli_query($con, "INSERT INTO Persons (Firsname, LastName, Age) VALUES ('Glenn', 'Quagmire', 33)");

echo "New record has id: ".mysqli_insert_id($con);
mysqli_close($con)
?>