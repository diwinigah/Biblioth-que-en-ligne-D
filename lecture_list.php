<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "includes/db/connexion.php";
include "navbar.php";

if (!isset($_SESSION["login_user"])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION["login_user"];

// Handle removing a book from the reading list
if (isset($_POST["remove_book"])) {
    $book_id = $_POST["book_id"];
    $sql = "DELETE FROM liste_lecture WHERE username = ? AND livre_id = ?";
    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($stmt, "si", $username, $book_id);
    if (mysqli_stmt_execute($stmt)) {
        echo '<script type="text/javascript">alert("Livre retiré de la liste.");</script>';
    } else {
        echo '<script type="text/javascript">alert("Erreur lors du retrait du livre.");</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ma Liste de Lecture - Bibliothèque</title>
    <link rel="stylesheet" href="includes/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="includes/css/styles.css">
    <style type="text/css">
        .list-container {
            padding: 30px;
            max-width: 900px;
            margin: 0 auto;
        }
        .reading-list-table {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .btn-remove {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-remove:hover {
            background-color: #c82333;
        }
        .book-img-list {
            width: 50px;
            height: 70px;
            object-fit: cover;
            border-radius: 5px;
        }
    </style>
</head>
<body class="wrapper">
    <div id="main">
        <div class="list-container">
            <h2 class="text-center" style="margin-bottom: 30px;">Ma Liste de Lecture</h2>

            <div class="reading-list-table">
                <table class="table table-hover">
                    <thead>
                        <tr style="background-color: dodgerblue; color: white;">
                            <th>Image</th>
                            <th>Titre</th>
                            <th>Auteur</th>
                            <th>Édition</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT l.image_url, l.titre, l.auteur, l.maison_edition, ll.livre_id
                                FROM liste_lecture ll
                                JOIN livres l ON ll.livre_id = l.id
                                WHERE ll.username = ?";
                        $stmt = mysqli_prepare($db, $sql);
                        mysqli_stmt_bind_param($stmt, "s", $username);
                        mysqli_stmt_execute($stmt);
                        $res = mysqli_stmt_get_result($stmt);

                        if (mysqli_num_rows($res) == 0) {
                            echo '<tr><td colspan="5" class="text-center">Votre liste de lecture est vide.</td></tr>';
                        } else {
                            while ($row = mysqli_fetch_assoc($res)) {
                                ?>
                                <tr class="text-center">
                                    <td><img src="includes/assets/images/<?php echo htmlspecialchars($row['image_url']); ?>" class="book-img-list" alt="Couverture"></td>
                                    <td class="text-left"><?php echo htmlspecialchars($row['titre']); ?></td>
                                    <td class="text-left"><?php echo htmlspecialchars($row['auteur']); ?></td>
                                    <td class="text-left"><?php echo htmlspecialchars($row['maison_edition']); ?></td>
                                    <td>
                                        <form method="post" style="display: inline;">
                                            <input type="hidden" name="book_id" value="<?php echo $row['livre_id']; ?>">
                                            <button type="submit" name="remove_book" class="btn-remove">
                                                <span class="glyphicon glyphicon-trash"></span> Retirer
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
