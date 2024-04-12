<?php

    $server_name = "localhost";
    $default_user = "root";
    $password = "";

    $db_name = "brain_central";

    $connection = mysqli_connect($server_name, $default_user, $password, $db_name);

    if(!$connection) {
        echo "Connection Failed";
    }