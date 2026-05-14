<?php
  include "../includes/db/connexion.php";
  include "navbar.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demandes de livres - Administration</title>
    <link rel="stylesheet" href="../includes/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../includes/css/styles.css">
    <style type="text/css">
        .request-container {
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 20px;
            max-width: 900px;
            margin: 0 auto;
        }
        .approve-box {
            background-color: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 30px;
            border-radius: 10px;
            width: 100%;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }
        .form-control {
            background-color: #fff;
            color: black;
            margin-bottom: 15px;
        }
        .table-responsive {
            margin-top: 30px;
            overflow-x: auto;
        }
        table tr:hover {
            background-color: #e3f2fd !important;
            transition: all 0.3s ease-in-out;
        }
    </style>
</head>
<body class="wrapper">
    <div id="main">
        <div class="request-container">
            <div class="approve-box">
                <h3 style="text-align: center; color: white; margin-bottom: 20px;">Gérer les Demandes de Livres</h3>
                <form action="" name="form1" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" name="username" class="form-control" placeholder="Nom d'utilisateur" required="">
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="id" class="form-control" placeholder="ID du livre" required="">
                        </div>
                    </div>
                    <button class="btn btn-default btn-block" name="submit" type="submit" style="background-color: dodgerblue; color: white; font-weight: bold;">Valider la Demande</button>
                </form>
            </div>

            <div class="table-responsive">
                <h3 style="text-align: center; color: black; margin-bottom: 20px;">Demandes en attente</h3>
                <?php
                if(isset($_SESSION['login_user']))
                {
                    $sql= "SELECT lecteurs.username, lecteurs.roll, livres.id, livres.titre, livres.auteur, livres.maison_edition, livres.nombre_exemplair FROM lecteurs INNER JOIN demande_livre ON lecteurs.username=demande_livre.username INNER JOIN livres ON demande_livre.id=livres.id WHERE demande_livre.aprouver = ''";
                    $res= mysqli_query($db,$sql);
                    if(mysqli_num_rows($res)==0)
                    {
                        echo "<div class='alert alert-info text-center'>Il n'y a aucune demande en attente.</div>";
                    }
                    else
                    {
                        echo "<table class='table table-bordered table-hover'> ";
                        echo "<thead style='background-color: dodgerblue; color: white;'>";
                        echo "<tr><th>Utilisateur</th><th>Matricule</th><th>ID</th><th>Titre</th><th>Auteur</th><th>Édition</th><th>Exemplaires</th></tr>";
                        echo "</thead>";
                        while($row=mysqli_fetch_assoc($res))
                        {
                            echo "<tr>";
                            echo "<td>".htmlspecialchars($row['username'])."</td>";
                            echo "<td>".htmlspecialchars($row['roll'])."</td>";
                            echo "<td>".htmlspecialchars($row['id'])."</td>";
                            echo "<td>".htmlspecialchars($row['titre'])."</td>";
                            echo "<td>".htmlspecialchars($row['auteur'])."</td>";
                            echo "<td>".htmlspecialchars($row['maison_edition'])."</td>";
                            echo "<td>".htmlspecialchars($row['nombre_exemplair'] ?? $row['nombre_exemplair'])."</td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                    }
                }
                else
                {
                    echo '<div class="alert alert-danger text-center">Veuillez vous connecter d\'abord.</div>';
                }

                if(isset($_POST['submit']))
                {
                    $_SESSION['name']=$_POST['username'];
                    $_SESSION['id']=$_POST['id'];
                    echo '<script type="text/javascript">window.location="approve.php"</script>';
                }
                ?>
            </div>
        </div>
    </div>

    <?php include "../includes/layout/footer.php"; ?>
</body>
</html>
