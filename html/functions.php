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

function get_user_by_email($email) {
    $connect = connect_database();
    $stmt = $connect->prepare("SELECT * FROM users WHERE user_email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
    $connect->close();
    return $user;
}


function get_user_subscribed_newsletters($user_email) {
    $mysqli = connect_database();
    
    $query = "SELECT newsletter FROM subscriptions WHERE user_email = ?";
    
    $subscribed_newsletters = array();
    
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param("s", $user_email);
        $stmt->execute();
        $result = $stmt->get_result();
 
        while ($row = $result->fetch_assoc()) {
            $subscribed_newsletters[] = $row['newsletter']; 
        }
        
        $stmt->close();
    } else {
        echo "Error: " . $mysqli->error;
    }
    
    $mysqli->close();
    
    return $subscribed_newsletters;
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

?>