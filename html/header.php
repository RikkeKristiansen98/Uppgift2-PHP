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
            <?php if (isset($_SESSION['user_id'])): ?>
            <nav> 
            <?php if ($_SESSION['role'] === 'customer'): ?>
            <a href="mySubscribers.php">Mina prenumeranter</a>
        <?php else: ?>
            <a href="mySubsciptions.php">Mina prenumerationer</a>
        <?php endif; ?>                
        <a href="newsletters.php">Alla nyhetsbrev</a>
                <?php if (isset($_SESSION['user_id'])): ?>
                <form action="logout.php" method="post" style="display:inline;">
                <button type="submit">Logga ut</button>
            </form>
            <?php endif; ?>

            </nav>
        <?php endif; ?>
</header>
</body>
</html>