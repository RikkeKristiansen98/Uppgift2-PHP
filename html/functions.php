<?php 
function connect_database() {
    $host = "db";
    $username = "root";
    $password = "notSecureChangeMe";
    $database = "uppgift2";

    $mysqli = new mysqli($host, $username, $password, $database);

    if ($mysqli->connect_error) {
        die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }

    return $mysqli;
}

function get_name($name = null) {
    if ($name) {
        return $name;
    }

    return "stranger";
}

function get_window_title($title) {
    return $title . ' - My awesome site';
}
?>
