<?php
  include "../includes/db/connexion.php";
  include "navbar.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retards - Administration</title>
    <link rel="stylesheet" href="../includes/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../includes/css/styles.css">
    <style type="text/css">
        .expired-container {
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 20px;
            max-width: 1100px;
            margin: 0 auto;
        }
        .action-box {
            background-color: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 20px;
            border-radius: 10px;
            width: 100%;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }
        .form-inline-custom {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            align-items: center;
            justify-content: center;
        }
        .form-control {
            background-color: #fff;
            color: black;
            margin-bottom: 0;
        }
        .table-responsive {
            margin-top: 30px;
            overflow-x: auto;
        }
        table tr:hover {
            background-color: #e3f2fd !important;
            transition: all 0.3s ease-in-out;
        }
        .btn-return { background-color: #06861a; color: yellow; font-weight: bold; }
        .btn-expired { background-color: red; color: yellow; font-weight: bold; }
    </style>
</head>
<body class="wrapper">
    <div id="main">
        <div class="expired-container">
            <div class="action-box">
                <h3 style="text-align: center; color: white; margin-bottom: 20px;">Gestion des Retards et Retours</h3>

                <?php if(isset($_SESSION['login_user'])): ?>
                <div class="row">
                    <div class="col-md-6 text-center">
                        <form method="post" action="">
                            <button name="submit2" type="submit" class="btn btn-default btn-return">MARQUER COMME RETOURNÉ</button>
                            <button name="submit3" type="submit" class="btn btn-default btn-expired">MARQUER COMME EXPIRÉ</button>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <form method="post" action="" class="form-inline-custom">
                            <input type="text" name="username" class="form-control" placeholder="Nom d'utilisateur" required="">
                            <input type="text" name="id" class="form-control" placeholder="ID Livre" required="">
                            <button class="btn btn-default" name="submit" type="submit" style="background-color: dodgerblue; color: white;">Valider</button>
                        </form>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <div class="table-responsive">
                <h3 style="text-align: center; color: black; margin-bottom: 20px;">Liste des Retards</h3>
                <?php
                if(isset($_SESSION['login_user']))
                {
                    $ret='<p style="color:yellow; background-color:green;">RETOURNÉ</p>';
                    $exp='<p style="color:yellow; background-color:red;">EXPIRÉ</p>';

                    if(isset($_POST['submit2'])) {
                        $sql="SELECT lecteurs.username, lecteurs.roll, livres.id, livres.titre, livres.auteur, livres.maison_edition, demande_livre.aprouver, demande_livre.demande, demande_livre.retour FROM lecteurs INNER JOIN demande_livre ON lecteurs.username=demande_livre.username INNER JOIN livres ON demande_livre.id=livres.id WHERE demande_livre.aprouver ='$ret' ORDER BY demande_livre.retour DESC";
                    } else if(isset($_POST['submit3'])) {
                        $sql="SELECT lecteurs.username, lecteurs.roll, livres.id, livres.titre, livres.auteur, livres.maison_edition, demande_livre.aprouver, demande_livre.demande, demande_livre.retour FROM lecteurs INNER JOIN demande_livre ON lecteurs.username=demande_livre.username INNER JOIN livres ON demande_livre.id=livres.id WHERE demande_livre.aprouver ='$exp' ORDER BY demande_livre.retour DESC";
                    } else {
                        $sql="SELECT lecteurs.username, lecteurs.roll, livres.id, livres.titre, livres.auteur, livres.maison_edition, demande_livre.aprouver, demande_livre.demande, demande_livre.retour FROM lecteurs INNER JOIN demande_livre ON lecteurs.username=demande_livre.username INNER JOIN livres ON demande_livre.id=livres.id WHERE demande_livre.aprouver !='' AND demande_livre.aprouver !='Yes' ORDER BY demande_livre.retour DESC";
                    }

                    $res=mysqli_query($db,$sql);

                    echo "<table class='table table-bordered table-hover'> ";
                    echo "<thead style='background-color: dodgerblue; color: white;'>";
                    echo "<tr><th>Utilisateur</th><th>Matricule</th><th>ID</th><th>Titre</th><th>Auteur</th><th>Édition</th><th>Statut</th><th>Date Emprunt</th><th>Date Retour</th></tr>";
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
                        echo "<td>".htmlspecialchars($row['aprouver'])."</td>";
                        echo "<td>".htmlspecialchars($row['demande'])."</td>";
                        echo "<td>".htmlspecialchars($row['retour'])."</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                }
                else
                {
                    echo '<div class="alert alert-danger text-center">Connectez-vous pour accéder à cette page.</div>';
                }

                if(isset($_POST['submit']))
                {
                    $var1='<p style="color:yellow; background-color:green;">RETOURNÉ</p>';
                    $sql = "SELECT * FROM demande_livre WHERE username=? AND id=?";
                    $stmt = mysqli_prepare($db, $sql);
                    mysqli_stmt_bind_param($stmt, "ss", $_POST['username'], $_POST['id']);
                    mysqli_stmt_execute($stmt);
                    $res = mysqli_stmt_get_result($stmt);

                    $day = 0;
                    $fine = 0;
                    while($row=mysqli_fetch_assoc($res))
                    {
                        $d= strtotime($row['retour']);
                        $c= strtotime(date("Y-m-d"));
                        $diff= $c-$d;

                        if($diff>=0)
                        {
                            $day= floor($diff/(60*60*24));
                            $fine= $day*0.10;
                        }
                    }

                    $x= date("Y-m-d");
                    $sql_fine = "INSERT INTO fine VALUES(?, ?, ?, ?, ?, 'not paid')";
                    $stmt_fine = mysqli_prepare($db, $sql_fine);
                    mysqli_stmt_bind_param($stmt_fine, "sssdd", $_POST['username'], $_POST['id'], $x, $day, $fine);
                    mysqli_stmt_execute($stmt_fine);

                    $sql_update = "UPDATE demande_livre SET aprouver=? WHERE username=? AND id=?";
                    $stmt_update = mysqli_prepare($db, $sql_update);
                    mysqli_stmt_bind_param($stmt_update, "sss", $var1, $_POST['username'], $_POST['id']);
                    mysqli_stmt_execute($stmt_update);

                    $sql_stock = "UPDATE livres SET nombre_exemplair = nombre_exemplair + 1 WHERE id=?";
                    $stmt_stock = mysqli_prepare($db, $sql_stock);
                    mysqli_stmt_bind_param($stmt_stock, "s", $_POST['id']);
                    mysqli_stmt_execute($stmt_stock);

                    echo '<script type="text/javascript">alert("Livre marqué comme retourné et amende calculée.");</script>';
                }
                ?>
            </div>
        </div>
    </div>

    <?php include "../includes/layout/footer.php"; ?>
</body>
</html>
