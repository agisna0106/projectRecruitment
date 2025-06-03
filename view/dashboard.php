<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kopi Form</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <head>
        <nav>
            <h2>Kopi<i class="keun">keun</i></h2>
            <button>Logout</button>
        </nav>
    </head>

    
    
    <section class="body">
        <div class="kopi-container">
            <?php
            for($i=0; $i<10; $i++):
            ?>
                <div class="kopi-card">
                    <img class="kopi-image" src="../assets/americano.png" alt="">
                    <p>Americano</p>
                </div>
            <?php endfor?>
        </div>
        
    </section>
    <footer></footer>
</body>
</html>