<?php
include "../includes/db/connexion.php";
include "navbar.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livres - Lecteur</title>
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

        /* Grid Layout for Books */
        .books-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
            padding: 20px;
            justify-content: center;
        }
        .book-card {
            background-color: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
            border: 1px solid #eee;
        }
        .book-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }
        .book-card-img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-bottom: 3px solid dodgerblue;
        }
        .book-card-content {
            padding: 15px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        .book-title {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
            height: 50px;
            overflow: hidden;
        }
        .book-author {
            font-style: italic;
            color: #666;
            margin-bottom: 10px;
            font-size: 14px;
        }
        .book-details {
            font-size: 13px;
            color: #444;
            margin-bottom: 15px;
            line-height: 1.4;
        }
        .detail-item {
            margin-bottom: 4px;
        }
        .detail-label {
            font-weight: bold;
            color: #555;
        }
        .book-footer {
            padding: 10px 15px;
            background-color: #f9f9f9;
            border-top: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
            color: #888;
        }
        .book-id-badge {
            background-color: dodgerblue;
            color: white;
            padding: 2px 8px;
            border-radius: 10px;
            font-weight: bold;
        }
    </style>
</head>
<body class="wrapper">
    <div id="main">
        <div class="search-container">
            <form class="search-box" action="" method="post" name="form1">
                <input class="form-control" type="text" name="search" placeholder="Rechercher un livre.. " required="">
                <button style="background-color: dodgerblue; color: white;" type="submit" name="submit" class="btn btn-default">
                    <span class="glyphicon glyphicon-search"></span> Rechercher
                </button>
            </form>
            <form class="search-box" action="" method="post" name="form2">
                <input class="form-control" type="text" name="id" placeholder="ID du livre pour demande..." required="">
                <button style="background-color: dodgerblue; color: white;" type="submit" name="submit1" class="btn btn-default">
                    Demande
                </button>
            </form>
        </div>

        <h2 class="text-center" style="margin-top: 30px;">Catalogue des Livres</h2>

        <div class="books-grid">
            <?php
            if(isset($_POST["submit"])) {
                $sql = "SELECT * FROM livres WHERE titre LIKE ? OR auteur LIKE ?";
                $stmt = mysqli_prepare($db, $sql);
                $searchTerm = "%" . $_POST['search'] . "%";
                mysqli_stmt_bind_param($stmt, "ss", $searchTerm, $searchTerm);
                mysqli_stmt_execute($stmt);
                $q = mysqli_stmt_get_result($stmt);

                if(mysqli_num_rows($q)==0) {
                    echo "<div class='alert alert-info text-center' style='grid-column: 1 / -1;'>Aucun livre trouvé. Recherchez à nouveau.</div>";
                } else {
                    while ($row=mysqli_fetch_assoc($q)) {
                        renderBookCard($row);
                    }
                }
            } else {
                $res=mysqli_query($db,"SELECT * FROM `livres` ORDER BY `titre` ASC;");
                while ($row=mysqli_fetch_array($res)) {
                    renderBookCard($row);
                }
            }

            function renderBookCard($row) {
                ?>
                <div class="book-card">
                    <img src="../includes/assets/images/<?php echo $row['image_url']; ?>" class="book-card-img" alt="Couverture">
                    <div class="book-card-content">
                        <div class="book-title"><?php echo htmlspecialchars($row['titre']); ?></div>
                        <div class="book-author">Par <?php echo htmlspecialchars($row['auteur']); ?></div>
                        <div class="book-details">
                            <div class="detail-item"><span class="detail-label">Édition:</span> <?php echo htmlspecialchars($row['maison_edition']); ?></div>
                            <div class="detail-item"><span class="detail-label">Exemplaires:</span> <?php echo htmlspecialchars($row['nombre_exemplair']); ?></div>
                            <div class="detail-item" style="margin-top: 10px; font-style: italic; color: #777;">
                                <?php echo htmlspecialchars($row['description']); ?>
                            </div>
                        </div>
                    </div>
                    <div class="book-footer">
                        <span class="book-id-badge">ID: <?php echo htmlspecialchars($row['id']); ?></span>
                        <span>© Library System</span>
                    </div>
                </div>
                <?php
            }

            if(isset($_POST["submit1"])) {
                if(isset($_SESSION["login_user"])) {
                    try {
                        $sql = "INSERT INTO demande_livre VALUES (?, ?, '', '', '')";
                        $stmt = mysqli_prepare($db, $sql);
                        mysqli_stmt_bind_param($stmt, "ss", $_POST['id'], $_SESSION['login_user']);
                        mysqli_stmt_execute($stmt);
                        echo '<script type="text/javascript">alert("Demande envoyée avec succès."); window.location="request.php";</script>';
                    } catch (mysqli_sql_exception $e) {
                        if ($e->getCode() == 1062) {
                            echo '<script type="text/javascript">alert("Ce livre a déjà été demandé.");</script>';
                        } else {
                            throw $e;
                        }
                    }
                } else {
                    echo '<script type="text/javascript">alert("Connectez-vous d\'abord.");</script>';
                }
            }
            ?>
        </div>
    </div>

    <?php include "../includes/layout/footer.php"; ?>
</body>
</html>
