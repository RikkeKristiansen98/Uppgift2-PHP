<?php 
require_once __DIR__ . '/config.php'; 

$env = loadEnv(__DIR__ . '/.env');

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

function send_email($to, $subject, $body) {
    $domain = DOMAIN_MAILGUN;
    $api_key = API_KEY;
    $from = "postmaster@$domain";

    //var_dump("Domain: $domain");
    //var_dump("API Key: $api_key");

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://api.mailgun.net/v3/$domain/messages");
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, "api:$api_key");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, [
        'from' => $from,
        'to' => $to,
        'subject' => $subject,
        'text' => $body,
    ]);

    $result = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($result === false) {
        $error = curl_error($ch);
        $errno = curl_errno($ch);
        var_dump("Curl error ($errno): $error");
        var_dump("Curl result: ", $result);
    } else {
        var_dump("HTTP status code: $http_code");
        var_dump("Response: $result");
    }

    curl_close($ch);

    if ($http_code == 200) {
        return true;
    } else {
        return false;
    }
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

function get_newsletter_by_id($id) {
    $connect = connect_database();
    $stmt = $connect->prepare("SELECT * FROM newsletter WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $newsletter = $result->fetch_assoc();
    $stmt->close();
    $connect->close();
    return $newsletter;
}

function update_newsletter($id, $title, $description) {
    $connect = connect_database();
    $stmt = $connect->prepare("UPDATE newsletter SET title = ?, description = ? WHERE id = ?");
    $stmt->bind_param("ssi", $title, $description, $id);
    $success = $stmt->execute();
    $stmt->close();
    $connect->close();
    return $success;
}

function get_user_subscriptions($user_email) {
    $connect = connect_database();

    $query = "SELECT n.title
              FROM subscriptions s
              INNER JOIN newsletter n ON s.newsletter = n.title 
              WHERE s.user_email = ?";
    
    $stmt = $connect->prepare($query);
    $stmt->bind_param("s", $user_email);
    $stmt->execute();
    $result = $stmt->get_result();

    $subscriptions = array();
    while ($row = $result->fetch_assoc()) {
        $subscriptions[] = $row['title'];
    }
    $stmt->close();
    $connect->close();

    return $subscriptions;
}
function get_customers_subscribers($customer_email) {
    $connect = connect_database();

    $query = "SELECT u.firstname, u.lastname, u.user_email, n.title
              FROM subscriptions s
              INNER JOIN users u ON s.user_email = u.user_email
              INNER JOIN newsletter n ON s.newsletter = n.title
              WHERE n.user = ?";
    
    $stmt = $connect->prepare($query);
    $stmt->bind_param("s", $customer_email);
    $stmt->execute();
    $result = $stmt->get_result();

    $subscribers = array();
    while ($row = $result->fetch_assoc()) {
        $subscribers[] = $row;
    }
    $stmt->close();
    $connect->close();

    return $subscribers;
}
function get_newsletters_by_user_email($user_email) {
    $connect = connect_database();
    $stmt = $connect->prepare("SELECT * FROM newsletter WHERE user = ?");
    $stmt->bind_param("s", $user_email); 
    $stmt->execute();
    $result = $stmt->get_result();
    $newsletters = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    $connect->close();
    return $newsletters;
}
?>