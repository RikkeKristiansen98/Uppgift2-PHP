<?php
session_start();
include 'functions.php';
include("header.php");

$newsletter_id = 2;

$connect = connect_database();

$sql = "SELECT * FROM newsletter WHERE id = ?";
$stmt = $connect->prepare($sql);
$stmt->bind_param("i", $newsletter_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "<h1>" . htmlspecialchars($row['title']) . "</h1>";
    echo "<p>" . htmlspecialchars($row['description']) . "</p>";
    echo "<p><strong>Skapad av: </strong>" . htmlspecialchars($row['user']) . "</p>";
} else {
    echo "Inget nyhetsbrev hittades.";
}

$stmt->close();
$connect->close();
?>
