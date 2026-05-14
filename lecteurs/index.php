<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliothèque en ligne - Lecteurs</title>
    <link rel="stylesheet" href="../includes/css/styles.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../includes/assets/bootstrap/css/bootstrap.min.css">
</head>
<body>
<div class="wrapper">
    <header>
        <div class="logo">
            <img src="../includes/assets/images/logo.jpg" alt="logo">
            <h1>SYSTÈME DE GESTION DE BIBLIOTHÈQUE EN LIGNE</h1>
        </div>
        <?php
        if(isset($_SESSION["login_user"]))
            { ?>
                	<nav>
					<ul>
						<li><a href="index.php">ACCUEIL</a></li>
						<li><a href="books.php">LIVRES</a></li>
						<li><a href="feedback.php">SUGGESTIONS</a></li>
						<li><a href="logout.php">DÉCONNEXION</a></li>
					</ul>
				</nav>
            <?php
            }else
            {
                ?>
            <nav>
				<ul>
					<li><a href="index.php">ACCUEIL</a></li>
					<li><a href="books.php">LIVRES</a></li>
					<li><a href="../login.php">CONNEXION</a></li>
					<li><a href="registration.php">INSCRIPTION</a></li>
					<li><a href="feedback.php">SUGGESTIONS</a></li>
				</ul>
			</nav>
                <?php
            }
        ?>
    </header>

    <section>
        <div class="sec_img">
            <div class="box">
                <h2>Bienvenue à la bibliothèque (Espace Lecteur) <br><br>
                     Ouvre à : 7h :00 <br><br>
                     Ferme à : 17:00 <br><br>
                </h2>
            </div>
        </div>
    </section>
    <?php
        include "../includes/layout/footer.php";
    ?>
</div>
</body>
</html>