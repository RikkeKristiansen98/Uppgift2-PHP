<?php
session_start();
include 'functions.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'customer') {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = validate_input($_POST['title']);
    $description = validate_input($_POST['description']);
    $user_email = $_SESSION['user_email'];

    $success = create_newsletter($title, $description, $user_email);

    if ($success) {
        $_SESSION['message'] = "Nyhetsbrevet har skapats!";
    } else {
        $_SESSION['message'] = "Det uppstod ett fel vid skapandet av nyhetsbrevet.";
    }

    header("Location: createNewsletter.php");
    exit;
}

include("header.php");
?>

<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skapa nyhetsbrev</title>
</head>
<body>

<h2>Skapa nyhetsbrev</h2>
<?php
if (isset($_SESSION['message'])) {
    echo '<p>' . $_SESSION['message'] . '</p>';
    unset($_SESSION['message']);
}
?>
<form action="createNewsletter.php" method="post">
    <label for="title">Rubrik:</label><br>
    <input type="text" id="title" name="title" required><br>
    <label for="description">Beskrivning:</label><br>
    <textarea id="description" name="description" rows="4" cols="50" required></textarea><br>
    <input type="submit" value="Skapa nyhetsbrev">
</form>

<a href="logout.php">Logga ut</a>

</body>
</html>
