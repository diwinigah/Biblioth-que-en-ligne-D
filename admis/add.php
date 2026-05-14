<?php
  session_start();
  include "../includes/db/connexion.php";
  if(!isset($_SESSION["login_user"])) {
      header("Location: ../login.php");
      exit();
  }
  include "navbar.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Ajouter un livre</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../includes/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../includes/css/styles.css">
    <style type="text/css">
        .add-book-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
            padding: 20px;
        }
        .book-form-box {
            background-color: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 30px;
            border-radius: 10px;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }
        .book-form-box h2 {
            color: white !important;
            text-align: center;
            margin-bottom: 25px;
            font-family: 'Lucida Console', monospace;
        }
        .form-control {
            background-color: #fff;
            color: black;
            margin-bottom: 15px;
        }
        .btn-submit {
            background-color: dodgerblue;
            color: white;
            width: 100%;
            height: 45px;
            font-weight: bold;
            font-size: 16px;
            border: none;
        }
        .btn-submit:hover {
            background-color: #1e88e5;
            color: white;
        }
    </style>
</head>
<body class="wrapper">
    <div id="main">
        <div class="add-book-container">
            <div class="book-form-box">
                <h2>Ajouter un nouveau livre</h2>

                <form action="" method="post" enctype="multipart/form-data">
                    <input type="text" name="titre" class="form-control" placeholder="Titre du livre" required=""><br>
                    <input type="text" name="auteur" class="form-control" placeholder=" Auteur du livre " required=""><br>
                    <textarea name="description" class="form-control" placeholder="Description du livre" required="" style="height: 100px;"></textarea><br>
                    <input type="text" name="maison_edition" class="form-control" placeholder="Edition" required=""><br>
                    <label style="font-size: 14px; margin-bottom: 5px; display: block;">Image du livre :</label>
                    <input type="file" name="file" class="form-control" required=""><br>

                    <button class="btn btn-default btn-submit" type="submit" name="submit">Ajouter le Livre</button>
                </form>
            </div>
        </div>

        <?php
            if(isset($_POST['submit']))
            {
              if(isset($_SESSION['login_user']))
              {
                $target_dir = "../includes/assets/images/";
                if(!is_dir($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }

                $image = $_FILES['file']['name'];
                move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $image);

                // Fixed SQL: Added column names to avoid "Column count doesn't match"
                $sql = "INSERT INTO `livres` (titre, auteur, description, maison_edition, nombre_exemplair, image_url) VALUES (?, ?, ?, ?, '1', ?)";
                if ($stmt = mysqli_prepare($db, $sql)) {
                    mysqli_stmt_bind_param($stmt, "sssss", $_POST['titre'], $_POST['auteur'], $_POST['description'], $_POST['maison_edition'], $image);

                    if(mysqli_stmt_execute($stmt)) {
                        echo '<div class="alert alert-success text-center" style="width: 90%; max-width: 600px; margin: 20px auto;">Livre ajouté avec succès.</div>';
                    }
                    mysqli_stmt_close($stmt);
                }
              }
              else
              {
                echo '<div class="alert alert-danger text-center" style="width: 90%; max-width: 600px; margin: 20px auto;">Veuillez vous connecter d\'abord.</div>';
              }
            }
        ?>
    </div>

    <?php include "../includes/layout/footer.php"; ?>
</body>
</html>
