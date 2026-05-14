<?php
include "../includes/db/connexion.php";
include "navbar.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le profil - Administration</title>
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
            max-width: 500px;
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
                <h2 style="text-align: center; color: white; margin-bottom: 25px;">Modifier les informations</h2>

                <?php
                    $sql = "SELECT * FROM admin WHERE username=?";
                    $stmt = mysqli_prepare($db, $sql);
                    mysqli_stmt_bind_param($stmt, "s", $_SESSION['login_user']);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    $row = mysqli_fetch_assoc($result);

                    $nom = $row['nom'] ?? "";
                    $prenom = $row['prenom'] ?? "";
                    $username = $row['username'] ?? "";
                    $password = $row['password'] ?? "";
                    $email = $row['email'] ?? "";
                    $image = $row['image'] ?? "default.png";
                ?>

                <div style="text-align: center; margin-bottom: 20px;">
                    <span style="color: white;">Bienvenue,</span>
                    <h4 style="color: white; margin-top: 5px;"><?php echo htmlspecialchars($_SESSION['login_user']); ?></h4>
                </div>

                <form action="" method="post" enctype="multipart/form-data">
                    <label>Photo de profil :</label>
                    <input class="form-control" type="file" name="file">

                    <label>Nom :</label>
                    <input class="form-control" type="text" name="nom" value="<?php echo htmlspecialchars($nom); ?>" required>

                    <label>Prénom :</label>
                    <input class="form-control" type="text" name="prenom" value="<?php echo htmlspecialchars($prenom); ?>" required>

                    <label>Nom d'utilisateur :</label>
                    <input class="form-control" type="text" name="username" value="<?php echo htmlspecialchars($username); ?>" required>

                    <label>Mot de passe :</label>
                    <input class="form-control" type="password" name="password" value="<?php echo htmlspecialchars($password); ?>" required>

                    <label>Email :</label>
                    <input class="form-control" type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>

                    <button class="btn btn-default btn-save" type="submit" name="submit">Enregistrer les modifications</button>
                </form>

                <?php
                    if(isset($_POST['submit']))
                    {
                        $nom = $_POST['nom'];
                        $prenom = $_POST['prenom'];
                        $username = $_POST['username'];
                        $password = $_POST['password'];
                        $email = $_POST['email'];

                        $target_dir = "../includes/assets/images/";
                        if(!is_dir($target_dir)) {
                            mkdir($target_dir, 0777, true);
                        }

                        if(!empty($_FILES['file']['name'])) {
                            $pic = $_FILES['file']['name'];
                            move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $pic);
                            $sql1 = "UPDATE admin SET image=?, nom=?, prenom=?, username=?, password=?, email=? WHERE username=?";
                            $stmt1 = mysqli_prepare($db, $sql1);
                            mysqli_stmt_bind_param($stmt1, "sssssss", $pic, $nom, $prenom, $username, $password, $email, $_SESSION['login_user']);
                        } else {
                            $pic = $image;
                            $sql1 = "UPDATE admin SET nom=?, prenom=?, username=?, password=?, email=? WHERE username=?";
                            $stmt1 = mysqli_prepare($db, $sql1);
                            mysqli_stmt_bind_param($stmt1, "ssssss", $nom, $prenom, $username, $password, $email, $_SESSION['login_user']);
                        }

                        if(mysqli_stmt_execute($stmt1))
                        {
                            $_SESSION['login_user'] = $username;
                            $_SESSION['image'] = $pic;
                            echo '<script type="text/javascript">alert("Enregistré avec succès."); window.location="profile.php";</script>';
                        }
                        else
                        {
                            echo '<div class="alert alert-danger text-center" style="margin-top:15px;">Erreur lors de la sauvegarde.</div>';
                        }
                    }
                ?>
            </div>
        </div>
    </div>

    <?php include "../includes/layout/footer.php"; ?>
</body>
</html>
