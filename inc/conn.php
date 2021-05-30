<?php
    $host           = "host = 127.0.0.1";
    $port           = "port = 5432";
    $dbname         = "dbname = WMMS";
    $credentials    = "user = postgres password = 3340";

    $db = pg_connect("$host $port $dbname $credentials");
    if(!$db) {
       echo"<script>console.log('Error : unable to open database\n')</script>";
    } else {
        echo"<script> console.log('Connect sucessfully')</script>";
    }
?>