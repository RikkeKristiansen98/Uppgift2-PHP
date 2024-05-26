<?php
session_start();
include 'functions.php';
include("header.php");

if (isset($_SESSION['message'])) {
    echo "<p>{$_SESSION['message']}</p>";
    unset($_SESSION['message']); 
}
$connect = connect_database();

$sql = "SELECT * FROM newsletter ORDER BY id DESC";
$result = $connect->query($sql);

$user_role = isset($_SESSION['role']) ? $_SESSION['role'] : null;
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;


$user_email = null;
if ($user_id) {
    $user = get_user_by_id($user_id);
    if ($user) {
        $user_email = $user['user_email'];
    }
}

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

        echo "<h1>" . htmlspecialchars($row['title']) . "</h1>";
        echo "<p>" . htmlspecialchars($row['description']) . "</p>";
        if ($user_role === 'subscriber' && $user_id) {
            // visa prenumerationsknapp för prenumeranter
            echo '<form action="subscribe.php" method="post" style="display:inline;">
                    <input type="hidden" name="newsletter_title" value="' . htmlspecialchars($row['title']) . '">
                    <input type="hidden" name="user_email" value="' . htmlspecialchars($user_email) . '">
                    <button type="submit">Abonnera på nyhetsbrev</button>
                  </form>';
        } elseif ($user_role === 'customer') {
            // om kund är inloggad, visa möjlighet att redigera 
            echo '<a href="edit_newsletter.php?id=' . htmlspecialchars($row['id']) . '">
                    <button>Klicka för att redigera nyhetsbrev</button>
                  </a>';
        }
        
        }
        echo "<hr>";
} else {
    echo "Inga nyhetsbrev hittades.";
}

$connect->close();
?>
