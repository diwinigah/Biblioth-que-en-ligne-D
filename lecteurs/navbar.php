<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    include_once "../includes/db/connexion.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <title>Connexion</title>
    <link rel="stylesheet" href="styles.css">
    <style type="text/css">
    section
    {
      margin-top: -20px;
        
    }
  .box1
{
	height: 500px;
	width: 450px;
	background-color: #030002;
	margin: 70px auto;
	opacity: .8;
	color: white;
	padding: 20px ;
}
  </style> 
    </head>
<body>
         <nav class="navbar navbar-inverse ">
          <div class="container-fluid">
                    <div class="navbar-header">      
                     <a class="navbar-brand active"> Système de gestion des bibliothèques</a>
                    </div>
                
                    <ul class="nav navbar-nav">
                        <li><a href="index.php">ACCUEIL</a></li>
                        <li><a href="books.php">LIVRES</a></li>
                        <li><a href="feedback.php">SUGGESTIONS</a></li>
                 </ul >
                 <?php
                 if(isset($_SESSION["login_user"]))
                    {
                        ?>
                         <ul class="nav navbar-nav">
                            <li><a href="profile.php">PROFIL</a></li>
                         </ul>

                     <ul class="nav navbar-nav navbar-right">
                        <li><a href="profile.php"><div style="color: white">
                            <?php
                             echo "<img class='img-circle profile_img' height=30 width=30 src='images/". $_SESSION['image'] ."'>" ;

                             echo " ". $_SESSION["login_user"] ;
                             ?>
                        </div>
                    
                    
                    
                    </a></li>
                     <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"> DÉCONNEXION</span></a></li>
                     </ul>
                    <?php
                    }
                        else
                            {
                            ?>
                           <ul class="nav navbar-nav navbar-right">
                       <li><a href="login.php"><span class="glyphicon glyphicon-log-out"> CONNEXION</span></a></li>
                        <li><a href="registration.php"><span class="glyphicon glyphicon-user"> INSCRIPTION</span></a></li>
                    </ul>
                    <?php
                        }

                    ?>
                
                   
            </div>
            </nav>
               <?php
      if(isset($_SESSION['login_user']))
      {
        $day=0;

        $exp='<p style="color:yellow; background-color:red;">EXPIRÉ</p>';
        $res= mysqli_query($db,"SELECT * FROM `demande_livre` where username ='$_SESSION[login_user]' and aprouver ='$exp' ;");
      while($row=mysqli_fetch_assoc($res))
      {
        $d= strtotime($row['retour']);
        $c= strtotime(date("Y-m-d"));
        $diff= $c-$d;

        if($diff>=0)
        {
          $day= $day+floor($diff/(60*60*24)); 
        } 
        
      }
      $_SESSION['fine']=$day*.10;
    }
    ?>
</body>
</html>