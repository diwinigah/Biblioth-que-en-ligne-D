<?php
include "../includes/db/connexion.php";
include "navbar.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Changer le mot de passe - Administration</title>
    <link rel="stylesheet" href="../includes/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../includes/css/styles.css">
    <style type="text/css">
        .password-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
            padding: 20px;
        }
        .password-box {
            background-color: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 30px;
            border-radius: 15px;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.4);
        }
        .form-control {
            background-color: #fff;
            color: black;
            margin-bottom: 15px;
        }
        .btn-update {
            background-color: dodgerblue;
            color: white;
            width: 100%;
            height: 45px;
            font-weight: bold;
            border: none;
            transition: background 0.3s;
        }
        .btn-update:hover {
            background-color: #1e88e5;
            color: white;
        }
    </style>
</head>
<body class="wrapper">
    <div id="main">
        <div class="password-container">
            <div class="password-box">
                <h2 style="text-align: center; color: white; margin-bottom: 25px; font-family: 'Lucida Console', monospace;">Changer le mot de passe</h2>

                <form action="" method="post">
                    <div class="form-group">
                        <input type="text" name="username" class="form-control" placeholder="Nom d'utilisateur" required="">
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" placeholder="Email" required="">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Nouveau mot de passe" required="">
                    </div>
                    <button class="btn btn-default btn-update" type="submit" name="submit">Mettre à jour</button>
                </form>

                <?php
                if(isset($_POST['submit']))
                {
                    $sql = "UPDATE admin SET password=? WHERE username=? AND email=?";
                    $stmt = mysqli_prepare($db, $sql);
                    mysqli_stmt_bind_param($stmt, "sss", $_POST['password'], $_POST['username'], $_POST['email']);
                    if(mysqli_stmt_execute($stmt))
                    {
                        echo '<script type="text/javascript">alert("Mot de passe mis à jour avec succès !"); window.location="profile.php";</script>';
                    }
                    else
                    {
                        echo '<div class="alert alert-danger text-center" style="margin-top:15px;">Erreur lors de la mise à jour.</div>';
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <?php include "../includes/layout/footer.php"; ?>
</body>
</html>
