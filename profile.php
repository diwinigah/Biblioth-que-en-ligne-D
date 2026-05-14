<?php
include "includes/db/connexion.php";
include "navbar.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <style type="text/css">
            .wrapper{
                width: 500px;
                margin: 0 auto;
                color: white;
            }
            .table > tbody > tr > td {
                padding: 6px; 
            }
    </style>
</head>
<body style="background-color: darkolivegreen;">
    <div class="container">
        <form action="" method="post">
            <button class="btn btn-default" style="float: right;" name="submit1">Modifier </button>
        </form>
        		<div class="wrapper">
 			<?php

 				if(isset($_POST['submit1']))
 				{
 					?>
 						<script type="text/javascript">
 							window.location="edit.php"
 						</script>
 					<?php
 				}
 				$q=mysqli_query($db,"SELECT * FROM lecteurs where username='$_SESSION[login_user]' ;");
 			?>
            <h2 style="text-align: center;">Mon Profil </h2>
            <?php
               $row=mysqli_fetch_assoc($q);

               echo "<div style= 'text-align: center;'>
                     <img class='img-circle profile-img'  height=120 width=120 src='images/" . $_SESSION['image'] ."' >
               </div>" ;
            ?>
            <div style= 'text-align: center; '> 
               <b> Bienvenue </b>
                <h4>
	 				<?php echo $_SESSION['login_user']; ?>
	 			</h4>
            </div>
            <?php
 				echo "<b>";
 				echo "<table class='table table-bordered'>";
	 				echo "<tr>";
	 					echo "<td>";
	 						echo "<b> NOM: </b>";
	 					echo "</td>";

	 					echo "<td>";
	 						echo $row['first'];
	 					echo "</td>";
	 				echo "</tr>";

	 				echo "<tr>";
	 					echo "<td>";
	 						echo "<b> Prénom : </b>";
	 					echo "</td>";
	 					echo "<td>";
	 						echo $row['last'];
	 					echo "</td>";
	 				echo "</tr>";

	 				echo "<tr>";
	 					echo "<td>";
	 						echo "<b> Nom d'utilisateur : </b>";
	 					echo "</td>";
	 					echo "<td>";
	 						echo $row['username'];
	 					echo "</td>";
	 				echo "</tr>";

	 				echo "<tr>";
	 					echo "<td>";
	 						echo "<b> Mot de passe : </b>";
	 					echo "</td>";
	 					echo "<td>";
	 						echo $row['password'];
	 					echo "</td>";
	 				echo "</tr>";

	 				echo "<tr>";
	 					echo "<td>";
	 						echo "<b> Email: </b>";	
	 					echo "</td>";
	 					echo "<td>";
	 						echo $row['email'];
	 					echo "</td>";
	 				echo "</tr>";

	 				
 				echo "</table>";
 				echo "</b>";
 			?>
        </div>

    </div>
    
</body>
</html>