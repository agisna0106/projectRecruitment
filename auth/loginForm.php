<?php 
require_once 'login.php';

$auth = new Login();
$auth->login();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <section class="loginregister">
        <form action="<?= $_SERVER['PHP_SELF']?>" method="POST">
            <a style="text-decoration: none;" href="../view/dashboard.php"><h2>Kopi<i>keun</i></h2></a>
            <div class="cardlr">
                <label for="username">Username : </label>
                <input type="text" name="username" id="username" required>
                <label for="password">Password : </label>
                <input type="password" name="password" id="password">
                <button type="submit" name="login" value="login">LOGIN</button>
            </div>
        </form>
    </section>
    
</body>
</html>