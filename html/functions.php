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

function get_user_by_id($user_id) {
    $connect = connect_database();
    $stmt = $connect->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
    $connect->close();
    return $user;
}

//Ta bort
function get_user_by_email($email) {
    $connect = connect_database();
    $stmt = $connect->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
    $connect->close();
    return $user;
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
