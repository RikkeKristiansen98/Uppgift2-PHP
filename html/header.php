<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : 'Nyhetsbrev sida'; ?></title>
</head>
<body>
<header>
    <h3>Nyhetsbrev sida</h3>
    <nav> 
        <?php if (isset($_SESSION['user_id'])): ?>
            <?php if ($_SESSION['role'] === 'customer'): ?>
                <a href="mySubscribers.php">Mina prenumeranter</a>
            <?php else: ?>
                <a href="mySubsciptions.php">Mina prenumerationer</a>
            <?php endif; ?>
            <a href="<?php echo ($_SESSION['role'] === 'customer') ? 'myNewsletter.php' : 'newsletters.php'; ?>">
                <?php echo ($_SESSION['role'] === 'customer') ? 'Mitt nyhetsbrev' : 'Alla nyhetsbrev'; ?>
            </a>
            <form action="logout.php" method="post" style="display:inline;">
                <button type="submit">Logga ut</button>
            </form>
        <?php else: ?>
            <a href="newsletters.php">Alla nyhetsbrev</a>
            <a href="login.php">Logga in</a>
            <a href="signUp.php">Skapa konto</a>
        <?php endif; ?>
    </nav>
</header>
</body>
</html>
