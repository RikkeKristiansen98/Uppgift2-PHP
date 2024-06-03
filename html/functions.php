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

function send_email() {
    $domain = //.env

    //hämta mottagare
    $to = "Rikke.kristiansen@medieinstitutet.se";
    //Hämta subject och body
    $ubject = "Testing email";
    $body = "Reset password here";
    //Hämta från 
    $from = "postmaster@$domain";

    //Hämta API nyckel
    $api_key=//.env; 

    //skicka brev
    $endpoint = "https://api.mailgun.net/v3/$domain/messages";
    //Lägga till innehåll
    $ch = curl_init($endpoint);

$form_fields = array (
    'to' => $to, 
    'from' => $from,
    'subject' => $subject, 
    'text' => $body
);
$query = http_build_query($form_fields);
var_dump($query);

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERPWD, "api:$api_key");
    //läs svar
   $result =  curl_exec($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
//läs svaret 
    curl_close($ch);
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

// TODO: skapa en function: get_customers_subscribers 

?>