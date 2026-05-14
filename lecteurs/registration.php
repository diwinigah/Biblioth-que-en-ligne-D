<?php
include "../includes/db/connexion.php";
include "navbar.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Lecteur</title>
    <link rel="stylesheet" href="../includes/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../includes/css/styles.css">
</head>
<body class="wrapper">
    <section class="reg_img">
        <div class="box2">
            <h3 style="text-align: center; color: white; margin-bottom: 20px;">
                Système de gestion des bibliothèques <br>
                Formulaire d'inscription Lecteur
            </h3>
            <form name="Registration" action="" method="post">
                <div class="login-fields">
                    <input class="form-control" type="text" name="nom" placeholder="Nom" required=""><br>
                    <input class="form-control" type="text" name="prenom" placeholder="Prénom" required=""><br>
                    <input class="form-control" type="text" name="username" placeholder="Nom d'utilisateur" required=""><br>
                    <input class="form-control" type="password" name="password" placeholder="Mot de passe" required=""><br>
                    <input class="form-control" type="email" name="email" placeholder="Email" required=""><br>
                    <button class="btn btn-default" type="submit" name="submit" style="color:black; width:100%; height:40px; margin-top: 10px; font-weight: bold;">S'inscrire</button>
                </div>
            </form>
        </div>
    </section>

    <?php
    if(isset($_POST["submit"])) {
          $count=0;
          $sql = "SELECT username FROM `lecteurs` WHERE username = ?";
          $stmt = mysqli_prepare($db, $sql);
          mysqli_stmt_bind_param($stmt, "s", $_POST['username']);
          mysqli_stmt_execute($stmt);
          mysqli_stmt_store_result($stmt);
          $count = mysqli_stmt_num_rows($stmt);

          if($count==0)
          {
            $sql_insert = "INSERT INTO `lecteurs` (username, password, email, image) VALUES (?, ?, ?, ?)";
            $stmt_insert = mysqli_prepare($db, $sql_insert);
            $img_default = 'p.jpg';
            mysqli_stmt_bind_param($stmt_insert, "ssss", $_POST['username'], $_POST['password'], $_POST['email'], $img_default);
            mysqli_stmt_execute($stmt_insert);
            echo '<script type="text/javascript">alert("Inscription réussie.");</script>';
          } else {
            echo '<script type="text/javascript">alert("Le nom d\'utilisateur existe déjà.");</script>';
          }
    }
    ?>

    <?php include "../includes/layout/footer.php"; ?>
</body>
</html>
