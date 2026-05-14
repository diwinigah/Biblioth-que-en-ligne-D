<?php 
include "../includes/db/connexion.php";
include "navbar.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>changer de mots de passe </title>
    <style type="text/css">
            body{
                height: 650px;
                
                background-image: url("images/bibl.jpg");
                background-repeat: no-repeat;

            }
            .warpper{
                width: 400px;
                height: 400px;
                margin: 100px auto;
                opacity: .8;
                background-color: black;
                color: white;
                padding: 27px 30px;
            }
            .form-control{
                width: 300px;
            }
    </style>
</head>
<body>
     <div class="warpper">
        <div style="text-align: center;">
             <h1 style="text-align: center; font-size: 35px;font-family: Lucida Console;">Changer le mot de passe</h1>     
     </div>
        <div style="padding-left: 20px">
             <form action="" method="post">
                <input type="text" name="username" class="form-control" placeholder="Nom d'utilisateur" required=""><br>
                <input type="text" name="email" class="form-control" placeholder="Email" required=""><br>
                <input type="" name="password" class="form-control" placeholder="Nouveau mot de passe" required=""><br>
                <button class="btn btn-default" type="submit" name="submit">Mettre à jour</button>

            </form>
        </div>
    
 	 <?php

		if(isset($_POST['submit']))
		{
            $sql = "UPDATE lecteurs SET password=? WHERE username=? AND email=?";
            $stmt = mysqli_prepare($db, $sql);
            mysqli_stmt_bind_param($stmt, "sss", $_POST['password'], $_POST['username'], $_POST['email']);
			if(mysqli_stmt_execute($stmt))
			{
                echo '<script type="text/javascript">alert("Mot de passe mis à jour avec succès");</script>';
			}
			
		}
	            ?>
    </div>
</body>
</html>