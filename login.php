<?php
include "includes/db/connexion.php";
include "navbar.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="includes/css/styles.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="includes/assets/bootstrap/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body class="wrapper">
    <section class="reg_img">
        <div class="box2">
            <h3 style="text-align: center; color: white; margin-bottom: 20px;">
                Système de gestion des bibliothèques <br>
                Formulaire de connexion utilisateur
            </h3>
            <form name="login" action="" method="post">
                <p style="text-align: center; font-weight: bold; font-size: 18px; margin-bottom: 20px;">Se connecter en tant que :</p>
                <div style="text-align: center; margin-bottom: 20px;">
                    <input type="radio" name="user" id="admin" value="admin">
                    <label for="admin">Admin</label>
                    <input type="radio" name="user" id="lecteurs" value="lecteurs" checked="">
                    <label for="lecteurs">Lecteur</label>
                </div>

                <div class="login-fields">
                    <input class="form-control" type="text" name="username" placeholder="Nom d'utilisateur" required=""><br>
                    <input class="form-control" type="password" name="password" placeholder="Mot de passe" required=""><br>
                    <button class="btn btn-default" type="submit" name="submit" style="color:black; width:100%; height:40px; margin-top: 10px; font-weight: bold;">Se connecter</button>
                </div>

                <p style="text-align: center; margin-top: 20px;">
                    <a id="forgot_link" style="color: yellow;" href="update_password.php?user=lecteurs">Mot de passe oublié ?</a>
                    <br> Nouveau sur le site ? <a style="color: yellow;" href="registration.php">Inscrivez-vous</a>
                </p>
            </form>
        </div>
    </section>

    <?php
       if(isset($_POST["submit"]))
        {
          if(!isset($_POST['user']))
          {
            echo '<div class="alert alert-danger text-center" style="width: 90%; max-width: 600px; margin: 20px auto;"><strong>Veuillez sélectionner un type d\'utilisateur.</strong></div>';
          }
          else if($_POST["user"]=='admin')
          {
              $sql = "SELECT * FROM `admin` WHERE username=? AND password=?";
              $stmt = mysqli_prepare($db, $sql);
              mysqli_stmt_bind_param($stmt, "ss", $_POST['username'], $_POST['password']);
              mysqli_stmt_execute($stmt);
              $res = mysqli_stmt_get_result($stmt);
              $row = mysqli_fetch_assoc($res);
              $count = mysqli_num_rows($res);

              if($count==0)
              {
                echo '<div class="alert alert-danger text-center" style="width: 90%; max-width: 600px; margin: 20px auto;"><strong>Le nom d’utilisateur et le mot de passe ne correspondent pas.</strong></div>';
              }
              else
              {
                $_SESSION['login_user'] = $_POST['username'];
                $_SESSION['image'] = $row['image'];
                echo '<script type="text/javascript">window.location="admis/index.php"</script>';
              }
          } else {
            $sql = "SELECT * FROM lecteurs WHERE username=? AND password=?";
            $stmt = mysqli_prepare($db, $sql);
            mysqli_stmt_bind_param($stmt, "ss", $_POST['username'], $_POST['password']);
            mysqli_stmt_execute($stmt);
            $res = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($res);
            $count = mysqli_num_rows($res);

            if($count==0){
                echo '<div class="alert alert-danger text-center" style="width: 90%; max-width: 600px; margin: 20px auto;"><strong> Le nom d’utilisateur et le mot de passe ne correspondent pas.</strong></div>';
            } else {
                $_SESSION["login_user"]= $_POST["username"];
                $_SESSION['image'] = $row['image'];
                echo '<script type="text/javascript">window.location="index.php"</script>';
            }
          }
        }
    ?>

    <script type="text/javascript">
      $(document).ready(function(){
        function updateLink() {
            var userType = $('input[name="user"]:checked').val();
            $('#forgot_link').attr('href', 'update_password.php?user=' + userType);
        }
        $('input[name="user"]').change(updateLink);
        updateLink();
      });
    </script>
</body>
</html>
