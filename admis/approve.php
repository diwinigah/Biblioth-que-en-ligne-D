<?php
  include "../includes/db/connexion.php";
  include "navbar.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approuver la demande - Administration</title>
    <link rel="stylesheet" href="../includes/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../includes/css/styles.css">
    <style type="text/css">
        .approve-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
            padding: 20px;
        }
        .approve-box {
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
        .btn-submit {
            background-color: dodgerblue;
            color: white;
            width: 100%;
            height: 45px;
            font-weight: bold;
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
        <div class="approve-container">
            <div class="approve-box">
                <h3 style="text-align: center; color: white; margin-bottom: 25px;">Approuver la Demande</h3>

                <form action="" method="post">
                    <div class="form-group">
                        <label>Décision (Oui ou Non) :</label>
                        <input class="form-control" type="text" name="approve" placeholder="Oui ou Non" required="">
                    </div>
                    <div class="form-group">
                        <label>Date d'emprunt (AAAA-MM-JJ) :</label>
                        <input type="text" name="issue" placeholder="Ex: 2026-05-13" required="" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Date de retour (AAAA-MM-JJ) :</label>
                        <input type="text" name="return" placeholder="Ex: 2026-05-20" required="" class="form-control">
                    </div>
                    <button class="btn btn-default btn-submit" type="submit" name="submit">Confirmer et Approuver</button>
                </form>
            </div>
        </div>
    </div>

    <?php
      if(isset($_POST['submit']))
      {
        $sql = "UPDATE demande_livre SET aprouver = ?, demande = ?, retour = ? WHERE username = ? AND id = ?";
        $stmt = mysqli_prepare($db, $sql);
        mysqli_stmt_bind_param($stmt, "sssss", $_POST['approve'], $_POST['issue'], $_POST['return'], $_SESSION['name'], $_SESSION['id']);
        mysqli_stmt_execute($stmt);

        $sql_book = "UPDATE livres SET nombre_exemplair = nombre_exemplair - 1 WHERE id = ?";
        $stmt_book = mysqli_prepare($db, $sql_book);
        mysqli_stmt_bind_param($stmt_book, "s", $_SESSION['id']);
        mysqli_stmt_execute($stmt_book);

        echo '<script type="text/javascript">alert("Mise à jour réussie."); window.location="request.php";</script>';
      }
    ?>

    <?php include "../includes/layout/footer.php"; ?>
</body>
</html>
