<?php
include 'functions.php';

$connect = connect_database(); 

$sql = "SELECT * FROM newsletter ORDER BY id DESC";
$result = $connect->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<h1>" . $row['title'] . "</h1>";
        echo "<p>" . $row['description'] . "</p>";
        echo "<hr>"; 
    }
} else {
    echo "Inga nyhetsbrev hittades.";
}

$connect->close();
?>
