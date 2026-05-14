<?php 
    session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
	  
	  <meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
  	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
     <title>Connexion Admin</title>
    </head>
<body>
         <nav class="navbar navbar-inverse ">
          <div class="container-fluid">
                    <div class="navbar-header">      
                     <a class="navbar-brand active"> Système de gestion des bibliothèques</a>
                    </div>
                
                    <ul class="nav navbar-nav">
                        <li><a href="/biblio/admis/index.php">ACCUEIL</a></li>
                        <li><a href="/biblio/admis/books.php">LIVRES</a></li>
                        <li><a href="/biblio/admis/feedback.php">SUGGESTIONS</a></li>
                 </ul >
                 <?php
                 if(isset($_SESSION["login_user"]))
                    {
                        ?>
                        <ul class="nav navbar-nav">
                             <li><a href="lecteur.php">INFOS-LECTEURS</a></li>
                    
                            <li><a href="profile.php">PROFIL</a></li>
                         </ul>
                     <ul class="nav navbar-nav navbar-right">
                        <li><a href="profile.php">
                            <div style="color: white">
                            <?php
                             echo "<img class='img-circle profile_img' hieght=30 width=30 src='images/". $_SESSION['image'] ."'>" ;
                             echo "  ".$_SESSION["login_user"] ;
                             ?>
                        </div>
                    
                    </a></li>
                     <li><a href="/biblio/admis/logout.php"><span class="glyphicon glyphicon-log-in"> DÉCONNEXION</span></a></li>
                     </ul>
                    <?php
                    }
                        else
                            {
                            ?>
                           <ul class="nav navbar-nav navbar-right">
                       <li><a href="/biblio/login.php"><span class="glyphicon glyphicon-log-out"> CONNEXION</span></a></li>
                        <li><a href="/biblio/admis/registration.php"><span class="glyphicon glyphicon-user"> INSCRIPTION</span></a></li>
                    </ul>
                    <?php
                        }

                    ?>
                
                   
            </div>
            </nav>