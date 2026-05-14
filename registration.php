<?php
include "includes/db/connexion.php";
include "navbar.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="includes/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="includes/css/styles.css">
</head>
<body class="wrapper">
    <section class="reg_img">
        <div class="box2">
            <h3 style="text-align: center; color: white; margin-bottom: 20px;">
                Système de gestion des bibliothèques <br>
                Formulaire d'inscription utilisateur
            </h3>
            <form name="signup" action="" method="post">
                <p style="text-align: center; font-weight: bold; font-size: 18px; margin-bottom: 20px;">Inscrivez-vous en tant que :</p>

                <div style="text-align: center; margin-bottom: 20px;">
                    <input type="radio" name="user" id="admin" value="admin">
                    <label for="admin">Admin</label>
                    <input type="radio" name="user" id="lecteurs" value="lecteurs" checked="">
                    <label for="lecteurs">Lecteur</label>
                </div>

                <div style="text-align: center;">
                    <button class="btn btn-default" type="submit" name="submit1" style="color:black; font-weight: bold; width:100%; height:40px;">Continuer</button>
                </div>
            </form>
        </div>
    </section>

    <?php
    if(isset($_POST["submit1"])) {
       if($_POST['user']=='admin')
          {
            echo '<script type="text/javascript">window.location="admis/registration.php"</script>';
          }
       else
       {
            echo '<script type="text/javascript">window.location="lecteurs/registration.php"</script>';
       }
    }
    ?>
</body>
</html>
