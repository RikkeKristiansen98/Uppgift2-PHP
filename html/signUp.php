<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skapa ett konto</title>
</head>
<body>

<form action="subscribe.php" method="post">
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
</body>
</html>