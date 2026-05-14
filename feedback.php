<?php
include "includes/db/connexion.php";
include "navbar.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suggestions - Bibliothèque</title>
    <link rel="stylesheet" href="includes/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="includes/css/styles.css">
    <style type="text/css">
        .feedback-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
            padding: 20px;
        }
        .feedback-box {
            background-color: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 30px;
            border-radius: 15px;
            width: 100%;
            max-width: 700px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.4);
        }
        .form-control-textarea {
            background-color: #fff;
            color: black;
            width: 100%;
            height: 100px;
            margin-bottom: 20px;
            padding: 10px;
            border-radius: 5px;
            border: none;
        }
        .btn-send {
            background-color: dodgerblue;
            color: white;
            font-weight: bold;
            width: 150px;
            height: 40px;
            border: none;
            transition: background 0.3s;
        }
        .btn-send:hover {
            background-color: #1e88e5;
            color: white;
        }
        .comments-section {
            margin-top: 30px;
            max-height: 400px;
            overflow-y: auto;
            padding-right: 10px;
        }
        .comment-row {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            margin-bottom: 10px;
            padding: 15px;
            border-radius: 8px;
            border-left: 5px solid dodgerblue;
        }
        .comment-user {
            font-weight: bold;
            color: #ffcc00;
            display: block;
            margin-bottom: 5px;
        }
    </style>
</head>
<body class="wrapper">
    <div id="main">
        <div class="feedback-container">
            <div class="feedback-box">
                <h3 style="text-align: center; color: white; margin-bottom: 10px;">Livre d'Or & Suggestions</h3>
                <p style="text-align: center; color: #ccc; margin-bottom: 25px;">Si vous avez des suggestions ou des questions, merci de commenter ci-dessous.</p>

                <form action="" method="post">
                    <textarea class="form-control-textarea" name="comment" placeholder="Ecrivez vos suggestions..." required></textarea>
                    <div style="text-align: center;">
                        <button class="btn btn-default btn-send" type="submit" name="submit">Envoyer</button>
                    </div>
                </form>

                <div class="comments-section">
                    <?php
                    if(isset($_POST['submit']))
                    {
                        $username = isset($_SESSION['login_user']) ? $_SESSION['login_user'] : 'Visiteur';
                        $sql="INSERT INTO `comments` (username, comment) VALUES(?, ?)";
                        $stmt = mysqli_prepare($db, $sql);
                        mysqli_stmt_bind_param($stmt, "ss", $username, $_POST['comment']);

                        if(mysqli_stmt_execute($stmt))
                        {
                            echo '<div class="alert alert-success text-center">Merci pour votre suggestion !</div>';
                        }
                    }

                    $q="SELECT * FROM `comments` ORDER BY `id` DESC";
                    $res=mysqli_query($db,$q);

                    if(mysqli_num_rows($res) > 0) {
                        while ($row=mysqli_fetch_assoc($res))
                        {
                            echo "<div class='comment-row'>";
                            echo "<span class='comment-user'>" . htmlspecialchars($row['username']) . "</span>";
                            echo "<span>" . htmlspecialchars($row['comment']) . "</span>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p class='text-center' style='color: #aaa;'>Aucun commentaire pour le moment.</p>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <?php include "includes/layout/footer.php"; ?>
</body>
</html>
