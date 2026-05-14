<?php
include "../includes/db/connexion.php";
include "navbar.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Infos-lecteurs - Administration</title>
    <link rel="stylesheet" href="../includes/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../includes/css/styles.css">
    <style type="text/css">
        .search-container {
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 15px;
            max-width: 800px;
            margin: 0 auto;
        }
        .search-box {
            display: flex;
            gap: 5px;
        }
        .table-responsive {
            margin: 20px;
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
        <div class="search-container">
            <form class="search-box" action="" method="post" name="form1">
                <input class="form-control" type="text" name="search" placeholder="Rechercher un nom d'utilisateur.. " required="">
                <button style="background-color: dodgerblue; color: white;" type="submit" name="submit" class="btn btn-default">
                    <span class="glyphicon glyphicon-search"></span> Rechercher
                </button>
            </form>
        </div>

        <div class="table-responsive">
            <h2 class="text-center">Liste des lecteurs</h2>
            <?php
            if(isset($_POST["submit"])) {
                $sql = "SELECT `id`, `first`, `last`, `username`, `roll`, `email` FROM `lecteurs` WHERE username LIKE ?";
                $stmt = mysqli_prepare($db, $sql);
                $search = "%" . $_POST['search'] . "%";
                mysqli_stmt_bind_param($stmt, "s", $search);
                mysqli_stmt_execute($stmt);
                $q = mysqli_stmt_get_result($stmt);

                if(mysqli_num_rows($q)==0) {
                    echo "<div class='alert alert-info text-center'>Aucun lecteur trouvé. Recherchez à nouveau.</div>";
                } else {
                    echo "<table class='table table-bordered table-hover'> ";
                    echo "<thead style='background-color: dodgerblue; color: white;'>";
                    echo "<tr><th>ID</th><th>Nom</th><th>Prénom</th><th>Nom d'utilisateur</th><th>Matricule</th><th>Email</th></tr>";
                    echo "</thead>";
                    while ($row=mysqli_fetch_assoc($q)) {
                        echo "<tr>";
                        echo "<td>".htmlspecialchars($row['id'])."</td>";
                        echo "<td>".htmlspecialchars($row['first'])."</td>";
                        echo "<td>".htmlspecialchars($row['last'])."</td>";
                        echo "<td>".htmlspecialchars($row['username'])."</td>";
                        echo "<td>".htmlspecialchars($row['roll'])."</td>";
                        echo "<td>".htmlspecialchars($row['email'])."</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                }
            } else {
                $res=mysqli_query($db,"SELECT `id`, `first`, `last`, `username`, `roll`, `email` FROM `lecteurs` ORDER BY `username` ASC;");
                echo "<table class='table table-bordered table-hover'> ";
                echo "<thead style='background-color: dodgerblue; color: white;'>";
                echo "<tr><th>ID</th><th>Nom</th><th>Prénom</th><th>Nom d'utilisateur</th><th>Matricule</th><th>Email</th></tr>";
                echo "</thead>";
                while ($row=mysqli_fetch_array($res)) {
                    echo "<tr>";
                    echo "<td>".htmlspecialchars($row['id'])."</td>";
                    echo "<td>".htmlspecialchars($row['first'])."</td>";
                    echo "<td>".htmlspecialchars($row['last'])."</td>";
                    echo "<td>".htmlspecialchars($row['username'])."</td>";
                    echo "<td>".htmlspecialchars($row['roll'])."</td>";
                    echo "<td>".htmlspecialchars($row['email'])."</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
            ?>
        </div>
    </div>

    <?php include "../includes/layout/footer.php"; ?>
</body>
</html>
