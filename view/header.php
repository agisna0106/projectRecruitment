<?php
session_start();
$loggedIn = isset($_SESSION['user']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KOPIkeun</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <head>
        <nav>
            <div class="nav-container">
                <a style="text-decoration: none;" href="dashboard.php"><h2>Kopi<i class="keun">keun</i></h2></a>
                <div class="menu-container">

                    <?php if ($loggedIn && $_SESSION['user']['role'] == 1): ?>
                        <a href="dashboard.php">Dashboard</a>
                        <a href="order.php">Order</a>
                    <?php elseif ($loggedIn && $_SESSION['user']['role'] == 2): ?>
                        <a href="transaksi.php">Transaksi</a>
                    <?php elseif ($loggedIn && $_SESSION['user']['role'] == 3): ?>
                        <a href="dashboard_owner.php">Dashboard</a>
                        <a href="kopi.php">Kopi</a>
                        <a href="users.php">Users</a>
                        <a href="keuangan.php">Pengeluaran</a>
                    <?php endif; ?>

                    <?php if ($loggedIn): ?>
                        <form action="../auth/logout.php" method="POST" style="display:inline;">
                            <button type="submit" class="btn-logout">Logout</button>
                        </form>
                    <?php else: ?>
                        <a style="margin: 0 0" href="../auth/loginForm.php"><button type="button" class="btn-logout">Login</button></a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </head>