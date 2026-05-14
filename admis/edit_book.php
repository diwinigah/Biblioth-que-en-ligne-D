<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "../includes/db/connexion.php";
include "navbar.php";

if (!isset($_SESSION["login_user"])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: books.php");
    exit();
}

$book_id = $_GET['id'];

// Fetch book details
$sql = "SELECT * FROM livres WHERE id = ?";
$stmt = mysqli_prepare($db, $sql);
mysqli_stmt_bind_param($stmt, "i", $book_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$book = mysqli_fetch_assoc($result);

if (!$book) {
    echo '<div class="alert alert-danger text-center">Livre non trouvé.</div>';
    echo '<a href="books.php" class="btn btn-default">Retour</a>';
    exit();
}

// Handle update
if (isset($_POST['submit'])) {
    $titre = $_POST['titre'];
    $auteur = $_POST['auteur'];
    $description = $_POST['description'];
    $maison_edition = $_POST['maison_edition'];
    $nombre_exemplair = $_POST['nombre_exemplair'];

    $target_dir = "../includes/assets/images/";
    if (!empty($_FILES['image']['name'])) {
        $pic = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], $target_dir . $pic);
        $update_sql = "UPDATE livres SET titre=?, auteur=?, description=?, maison_edition=?, nombre_exemplair=?, image_url=? WHERE id=?";
        $stmt_update = mysqli_prepare($db, $update_sql);
        mysqli_stmt_bind_param($stmt_update, "ssssii", $titre, $auteur, $description, $maison_edition, $nombre_exemplair, $pic, $book_id);
    } else {
        $update_sql = "UPDATE livres SET titre=?, auteur=?, description=?, maison_edition=?, nombre_exemplair=? WHERE id=?";
        $stmt_update = mysqli_prepare($db, $update_sql);
        mysqli_stmt_bind_param($stmt_update, "ssssii", $titre, $auteur, $description, $maison_edition, $nombre_exemplair, $book_id);
    }

    if (mysqli_stmt_execute($stmt_update)) {
        echo '<script type="text/javascript">alert("Livre mis à jour avec succès."); window.location="books.php";</script>';
    } else {
        echo '<div class="alert alert-danger text-center">Erreur lors de la mise à jour du livre.</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le Livre - Administration</title>
    <link rel="stylesheet" href="../includes/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../includes/css/styles.css">
    <style type="text/css">
        .edit-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
            padding: 20px;
        }
        .edit-box {
            background-color: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 30px;
            border-radius: 15px;
            width: 100%;
            max-width: 600px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.4);
        }
        .form-control {
            background-color: #fff;
            color: black;
            margin-bottom: 15px;
        }
        .btn-save {
            background-color: dodgerblue;
            color: white;
            width: 100%;
            height: 45px;
            font-weight: bold;
            border: none;
            transition: background 0.3s;
        }
        .btn-save:hover {
            background-color: #1e88e5;
            color: white;
        }
        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
            color: #ccc;
        }
    </style>
</head>
<body class="wrapper">
    <div id="main">
        <div class="edit-container">
            <div class="edit-box">
                <h2 style="text-align: center; color: white; margin-bottom: 25px;">Modifier le Livre</h2>

                <form action="" method="post" enctype="multipart/form-data">
                    <label>Image de couverture :</label>
                    <div style="margin-bottom: 15px;">
                        <img src="../includes/assets/images/<?php echo htmlspecialchars($book['image_url']); ?>" style="width: 80px; height: 110px; object-fit: cover; border-radius: 5px; margin-bottom: 10px;">
                        <input class="form-control" type="file" name="image">
                    </div>

                    <label>Titre :</label>
                    <input class="form-control" type="text" name="titre" value="<?php echo htmlspecialchars($book['titre']); ?>" required>

                    <label>Auteur :</label>
                    <input class="form-control" type="text" name="auteur" value="<?php echo htmlspecialchars($book['auteur']); ?>" required>

                    <label>Maison d'édition :</label>
                    <input class="form-control" type="text" name="maison_edition" value="<?php echo htmlspecialchars($book['maison_edition']); ?>" required>

                    <label>Nombre d'exemplaires :</label>
                    <input class="form-control" type="number" name="nombre_exemplair" value="<?php echo htmlspecialchars($book['nombre_exemplair']); ?>" required>

                    <label>Description :</label>
                    <textarea class="form-control" name="description" rows="4" required><?php echo htmlspecialchars($book['description']); ?></textarea>

                    <button class="btn btn-default btn-save" type="submit" name="submit">Enregistrer les modifications</button>
                </form>
            </div>
        </div>
    </div>

    <?php include "../includes/layout/footer.php"; ?>
</body>
</html>
