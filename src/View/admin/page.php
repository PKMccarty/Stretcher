<?php
    echo "<pre>";
    echo print_r($_GET);
    echo "</pre>";

    $result = base64_decode($_GET['id']);

    echo $result;
?>