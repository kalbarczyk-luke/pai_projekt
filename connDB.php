<?php
    DEFINE ('DB_USER', 'lab4');
    DEFINE ('DB_PASSWORD', '1234');
    DEFINE ('DB_HOST', 'localhost');
    DEFINE ('DB_NAME', 'pai_kalbarczyk');

    $conn = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die ('Nie polaczono z BD: ' . mysqli_connect_error()); 
?>