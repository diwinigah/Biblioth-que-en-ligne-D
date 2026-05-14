<?php
  include "../includes/db/connexion.php";
  include "navbar.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Demandes - Bibliothèque</title>
    <link rel="stylesheet" href="../includes/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../includes/css/styles.css">
    <style type="text/css">
        .request-container {
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 80vh;
        }
        .request-box {
            background-color: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 30px;
            border-radius: 15px;
            width: 100%;
            max-width: 800px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.4);
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
        <div class="request-container">
            <div class="request-box">
                <h3 style="text-align: center; color: white; margin-bottom: 25px;">Mes Demandes de Livres</h3>

                <?php
                if(isset($_SESSION['login_user']))
                {
                    $sql = "SELECT * FROM demande_livre WHERE username = ? AND aprouver = ''";
                    $stmt = mysqli_prepare($db, $sql);
                    mysqli_stmt_bind_param($stmt, "s", $_SESSION['login_user']);
                    mysqli_stmt_execute($stmt);
                    $res = mysqli_stmt_get_result($stmt);

                    if(mysqli_num_rows($res) == 0)
                    {
                        echo "<div class='alert alert-info text-center'>Vous n'avez aucune demande en attente.</div>";
                    }
                    else
                    {
                        echo "<div class='table-responsive'>";
                        echo "<table class='table table-bordered table-hover'>";
                        echo "<thead style='background-color: dodgerblue; color: white;'>";
                        echo "<tr><th>ID Livre</th><th>Statut</th><th>Date Emprunt</th><th>Date Retour</th></tr>";
                        echo "</thead>";

                        while($row = mysqli_fetch_assoc($res))
                        {
                            echo "<tr>";
                            echo "<td>".htmlspecialchars($row['id'])."</td>";
                            echo "<td>".htmlspecialchars($row['aprouver'])."</td>";
                            echo "<td>".htmlspecialchars($row['demande'])."</td>";
                            echo "<td>".htmlspecialchars($row['retour'])."</td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                        echo "</div>";
                    }
                }
                else
                {
                    echo '<div class="alert alert-danger text-center">Veuillez vous connecter d\'abord pour voir vos demandes.</div>';
                }
                ?>
            </div>
        </div>
    </div>

    <?php include "../includes/layout/footer.php"; ?>
</body>
</html>
