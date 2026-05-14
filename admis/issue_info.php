<?php
  include "../includes/db/connexion.php";
  include "navbar.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livres empruntés - Administration</title>
    <link rel="stylesheet" href="../includes/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../includes/css/styles.css">
    <style type="text/css">
        .issue-container {
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 80vh;
        }
        .issue-box {
            background-color: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 30px;
            border-radius: 10px;
            width: 100%;
            max-width: 1100px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }
        .table-responsive {
            margin-top: 20px;
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
        <div class="issue-container">
            <div class="issue-box">
                <h3 style="text-align: center; color: white; margin-bottom: 25px;">Informations sur les livres empruntés</h3>

                <?php
                if(isset($_SESSION['login_user']))
                {
                    $sql="SELECT lecteurs.username, lecteurs.roll, livres.id, livres.titre, livres.auteur, livres.maison_edition, demande_livre.demande, demande_livre.retour FROM lecteurs INNER JOIN demande_livre ON lecteurs.username=demande_livre.username INNER JOIN livres ON demande_livre.id=livres.id WHERE demande_livre.aprouver ='Yes' ORDER BY demande_livre.retour ASC";
                    $res=mysqli_query($db,$sql);

                    echo "<div class='table-responsive'>";
                    echo "<table class='table table-bordered table-hover'> ";
                    echo "<thead style='background-color: dodgerblue; color: white;'>";
                    echo "<tr><th>Utilisateur</th><th>Matricule</th><th>ID</th><th>Titre</th><th>Auteur</th><th>Édition</th><th>Date Emprunt</th><th>Date Retour</th></tr>";
                    echo "</thead>";

                    while($row=mysqli_fetch_assoc($res))
                    {
                        $d=date("Y-m-d");
                        $status_class = "";
                        $status_text = "";

                        if($d > $row['retour'])
                        {
                            $status_class = "table-danger";
                            $status_text = " (EXPIRÉ)";

                            // Update status in DB to mark as expired
                            $exp_val = '<p style="color:yellow; background-color:red;">EXPIRÉ</p>';
                            mysqli_query($db, "UPDATE demande_livre SET aprouver='$exp_val' WHERE username='".$row['username']."' AND id='".$row['id']."'");
                        }

                        echo "<tr class='$status_class'>";
                        echo "<td>".htmlspecialchars($row['username'])."</td>";
                        echo "<td>".htmlspecialchars($row['roll'])."</td>";
                        echo "<td>".htmlspecialchars($row['id'])."</td>";
                        echo "<td>".htmlspecialchars($row['titre'])."</td>";
                        echo "<td>".htmlspecialchars($row['auteur'])."</td>";
                        echo "<td>".htmlspecialchars($row['maison_edition'])."</td>";
                        echo "<td>".htmlspecialchars($row['demande'])."</td>";
                        echo "<td>".htmlspecialchars($row['retour']).$status_text."</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                    echo "</div>";
                }
                else
                {
                    echo '<div class="alert alert-danger text-center">Veuillez vous connecter pour voir les informations des livres empruntés.</div>';
                }
                ?>
            </div>
        </div>
    </div>

    <?php include "../includes/layout/footer.php"; ?>
</body>
</html>
