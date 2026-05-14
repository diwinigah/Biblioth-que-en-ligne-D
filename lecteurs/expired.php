<?php
  include "../includes/db/connexion.php";
  include "navbar.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retards - Lecteur</title>
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
                <h3 style="text-align: center; color: white; margin-bottom: 20px;">Mes Retards et Retours</h3>

                <?php if(isset($_SESSION['login_user'])): ?>
                <div class="text-center">
                    <form method="post" action="">
                        <button name="submit2" type="submit" class="btn btn-default btn-return">VOIR RETOURNÉS</button>
                        &nbsp;&nbsp;
                        <button name="submit3" type="submit" class="btn btn-default btn-expired">VOIR EXPIRÉS</button>
                    </form>
                </div>
                <?php endif; ?>
            </div>

            <div class="table-responsive">
                <h3 style="text-align: center; color: black; margin-bottom: 20px;">Détails des livres</h3>
                <?php
                if(isset($_SESSION['login_user']))
                {
                    $ret='<p style="color:yellow; background-color:green;">RETOURNÉ</p>';
                    $exp='<p style="color:yellow; background-color:red;">EXPIRÉ</p>';

                    if(isset($_POST['submit2'])) {
                        $sql="SELECT lecteurs.username, lecteurs.roll, livres.id, livres.titre, livres.auteur, livres.maison_edition, demande_livre.aprouver, demande_livre.demande, demande_livre.retour FROM lecteurs INNER JOIN demande_livre ON lecteurs.username=demande_livre.username INNER JOIN livres ON demande_livre.id=livres.id WHERE demande_livre.aprouver ='$ret' AND demande_livre.username ='$_SESSION[login_user]' ORDER BY demande_livre.retour DESC";
                    } else if(isset($_POST['submit la3'])) {
                        $sql="SELECT lecteurs.username, lecteurs.roll, livres.id, livres.titre, livres.auteur, livres.maison_edition, demande_livre.aprouver, demande_livre.demande, demande_livre.retour FROM lecteurs INNER JOIN demande_livre ON lecteurs.username=demande_livre.username INNER JOIN livres ON demande_livre.id=livres.id WHERE demande_livre.aprouver ='$exp' AND demande_livre.username ='$_SESSION[login_user]' ORDER BY demande_livre.retour DESC";
                    } else {
                        $sql="SELECT lecteurs.username, lecteurs.roll, livres.id, livres.titre, livres.auteur, livres.maison_edition, demande_livre.aprouver, demande_livre.demande, demande_livre.username FROM lecteurs INNER JOIN demande_livre ON lecteurs.username=demande_livre.username INNER JOIN livres ON demande_livre.id=livres.id WHERE demande_livre.aprouver !='' AND demande_livre.aprouver !='Yes' AND demande_livre.username ='$_SESSION[login_user]' ORDER BY demande_livre.retour DESC";
                    }

                    // Note: Corrected a few potential typos in the SQL logic for consistency
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
                ?>
            </div>
        </div>
    </div>

    <?php include "../includes/layout/footer.php"; ?>
</body>
</html>
