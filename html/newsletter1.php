<?php
include 'functions.php';

$connect = connect_database(); 

$sql = "SELECT * FROM newsletter ORDER BY id DESC LIMIT 1";
$result = $connect->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "<h1>" . $row['title'] . "</h1>";
    echo "<p>" . $row['description'] . "</p>";
} else {
    echo "Inget nyhetsbrev funnet.";
}

$connect->close();
?>


