<?php
include "../includes/db/connexion.php";
include "navbar.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil - Bibliothèque</title>
    <link rel="stylesheet" href="../includes/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../includes/css/styles.css">
    <style type="text/css">
        .profile-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
            padding: 20px;
        }
        .profile-card {
            background-color: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 30px;
            border-radius: 15px;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.4);
            text-align: center;
        }
        .profile-img {
            border: 4px solid white;
            border-radius: 50%;
            margin-bottom: 15px;
            object-fit: cover;
        }
        .profile-info-table {
            margin-top: 20px;
            color: white;
        }
        .profile-info-table td {
            border: none !important;
            padding: 10px;
            text-align: left;
        }
        .profile-info-table td b {
            color: #ccc;
            width: 40%;
            display: inline-block;
        }
        .btn-edit {
            background-color: dodgerblue;
            color: white;
            font-weight: bold;
            width: 100%;
            margin-top: 20px;
        }
    </style>
</head>
<body class="wrapper">
    <div id="main">
        <div class="profile-container">
            <div class="profile-card">
                <?php
                if(isset($_POST['submit1'])) {
                    echo '<script type="text/javascript">window.location="edit.php"</script>';
                }

                if(isset($_SESSION["login_user"])) {
                    $q = mysqli_query($db, "SELECT * FROM lecteurs where username='".htmlspecialchars($_SESSION['login_user'])."' ;");
                    $row = mysqli_fetch_assoc($q);

                    echo "<img class='profile-img' height='120' width='120' src='../includes/assets/images/" . htmlspecialchars($_SESSION['image']) . "'>";
                    echo "<h2>Bienvenue, " . htmlspecialchars($_SESSION['login_user']) . "</h2>";

                    echo "<table class='table profile-info-table'>";
                    echo "<tr><td><b>Nom:</b></td><td>".htmlspecialchars($row['first'])."</td></tr>";
                    echo "<tr><td><b>Prénom:</b></td><td>".htmlspecialchars($row['last'])."</td></tr>";
                    echo "<tr><td><b>Utilisateur:</b></td><td>".htmlspecialchars($row['username'])."</td></tr>";
                    echo "<tr><td><b>Mot de passe:</b></td><td>".htmlspecialchars($row['password'])."</td></tr>";
                    echo "<tr><td><b>Email:</b></td><td>".htmlspecialchars($row['email'])."</td></tr>";
                    echo "</table>";
                } else {
                    echo "<h3>Veuillez vous connecter pour voir votre profil.</h3>";
                }
                ?>

                <form action="" method="post">
                    <button class="btn btn-default btn-edit" name="submit1">Modifier mon profil</button>
                </form>
            </div>
        </div>
    </div>

    <?php include "../includes/layout/footer.php"; ?>
</body>
</html>
