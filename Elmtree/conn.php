<?php
        $host = "";
        $user = "";
        $pw = "";
        $db = "";

        $conn = new mysqli($host, $user, $pw, $db);

        if($conn->connect_error) {
          echo $conn->connect_error;
        }
?>
