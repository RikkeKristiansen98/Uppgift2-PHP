<?php
session_start(); // Flyttad session_start till början av filen

include 'functions.php';

function validate_input($data) {
    $data = trim($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Kontrollera om det finns ett meddelande att visa och visa det
if (isset($_SESSION['message'])) {
    echo '<p>' . $_SESSION['message'] . '</p>';
    unset($_SESSION['message']); // Rensa meddelandet från sessionen efter att det har visats
}
?>

<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skapa ett konto</title>
</head>
<body>

<form action="signup_handler.php" method="post">
    <label for="firstname">Namn: <input type="text" name="firstname" required></label><br>
    <label for="lastname">Efternamn: <input type="text" name="lastname" required></label><br>
    <label for="email">Email: <input type="email" name="email" required></label><br>
    <label for="password">Lösenord: <input type="password" name="password" required></label><br>
    <label for="role">Jag är: 
        <select name="role" required>
            <option value="customer">Kund</option>
            <option value="subscriber">Prenumerant</option>
        </select>
    </label><br>
    <input type="submit" name="submit" value="Skapa konto">
</form>
<a href="index.php"><button>Tillbaka till startsidan</button></a>
</body>
</html>
