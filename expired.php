<?php
  include "includes/db/connexion.php";
  include "navbar.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title>Retards</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<style type="text/css">

		.srch
		{
			padding-left: 70%;

		}
		.form-control
		{
			width: 300px;
			height: 40px;
			background-color: black;
			color: white;
		}
		
		body {
			background-image: url("images/aa.jpg");
			background-repeat: no-repeat;
  	font-family: "Lato", sans-serif;
  	transition: background-color .5s;
}

.sidenav {
  height: 100%;
  margin-top: 50px;
  width: 0;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: #222;
  overflow-x: hidden;
  transition: 0.5s;
  padding-top: 60px;
}

.sidenav a {
  padding: 8px 8px 8px 32px;
  text-decoration: none;
  font-size: 25px;
  color: #818181;
  display: block;
  transition: 0.3s;
}

.sidenav a:hover {
  color: white;
}

.sidenav .closebtn {
  position: absolute;
  top: 0;
  right: 25px;
  font-size: 36px;
  margin-left: 50px;
}

#main {
  transition: margin-left .5s;
  padding-left: 15px;
}

@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 18px;}
}
.img-circle
{
	margin-left: 20px;
}
.h:hover
{
	color:white;
	width: 300px;
	height: 50px;
	background-color: #00544c;
}
.container
{
	height: 800px;
  width: 85%;
	background-color: black;
	opacity: .8;
	color: white;
  margin-top: -25px;
}
.scroll
{
  width: 100%;
  height: 400px;
  overflow: auto;
}
th,td
{
  width: 10%;
}

	</style>

</head>
<body>

	
	<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

  			<div style="color: white; margin-left: 60px; font-size: 20px;">

                <?php
                if(isset($_SESSION['login_user']))

                { 	echo "<img class='img-circle profile_img' height=120 width=120 src='images/".$_SESSION['image']."'>";
                    echo "</br></br>";

                    echo "Welcome ".$_SESSION['login_user']; 
                }
                ?>
            </div><br><br>

 
  <div class="h"> <a href="books.php">Livres</a></div>
  <div class="h"> <a href="request.php">Demandes de livres</a></div>
  <div class="h"> <a href="expired.php">Livres empruntés</a></div>
  <div class="h"><a href="expired.php">Retards</a></div>
</div>

<div id="main">
  
  <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; Ouvrir</span>


	<script>
	function openNav() {
	  document.getElementById("mySidenav").style.width = "300px";
	  document.getElementById("main").style.marginLeft = "300px";
	  document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
	}

	function closeNav() {
	  document.getElementById("mySidenav").style.width = "0";
	  document.getElementById("main").style.marginLeft= "0";
	  document.body.style.backgroundColor = "white";
	}
	</script>
  <div class="container">
    
    <?php
      if(isset($_SESSION['login_user']))
      {
        ?>
      <div style="float: left; padding-left: 5px; padding-top: 20px;">
      <form method="post" action="">
          <button name="submit2" type="submit" class="btn btn-default" style="background-color: #06861a; color: yellow;">RETOURNÉ</button> 
                      &nbsp&nbsp
          <button name="submit3" type="submit" class="btn btn-default" style="background-color: red; color: yellow;">EXPIRÉ</button>
      </form>
      </div>
      <div style="float: right;padding-top: 10px;">
        <?php 
        $var=0;
          $result=mysqli_query($db,"SELECT * FROM `fine` where username='$_SESSION[login_user]' and status='not paid' ;");
          while($r=mysqli_fetch_assoc($result))
          {
            $var=$var+$r['fine'];
          }
          $var2=$var+$_SESSION['fine'];
         ?>
        
      </div>
      <?php
      }
    
    $c=0;

      
         $ret='<p style="color:yellow; background-color:green;">RETOURNÉ</p>';
         $exp='<p style="color:yellow; background-color:red;">EXPIRÉ</p>';
        
        if(isset($_POST['submit2']))
        {
          
        $sql="SELECT lecteurs.username, lecteurs.roll, livres.id, livres.titre, livres.auteur, livres.maison_edition, demande_livre.aprouver, demande_livre.demande, demande_livre.retour FROM lecteurs INNER JOIN demande_livre ON lecteurs.username=demande_livre.username INNER JOIN livres ON demande_livre.id=livres.id WHERE demande_livre.aprouver ='$ret' AND demande_livre.username ='$_SESSION[login_user]' ORDER BY demande_livre.retour DESC";
        $res=mysqli_query($db,$sql);

        }
        else if(isset($_POST['submit3']))
        {
        $sql="SELECT lecteurs.username, lecteurs.roll, livres.id, livres.titre, livres.auteur, livres.maison_edition, demande_livre.aprouver, demande_livre.demande, demande_livre.retour FROM lecteurs INNER JOIN demande_livre ON lecteurs.username=demande_livre.username INNER JOIN livres ON demande_livre.id=livres.id WHERE demande_livre.aprouver ='$exp' AND demande_livre.username ='$_SESSION[login_user]' ORDER BY demande_livre.retour DESC";
        $res=mysqli_query($db,$sql);
        }
        else
        {
        $sql="SELECT lecteurs.username, lecteurs.roll, livres.id, livres.titre, livres.auteur, livres.maison_edition, demande_livre.aprouver, demande_livre.demande, demande_livre.retour FROM lecteurs INNER JOIN demande_livre ON lecteurs.username=demande_livre.username INNER JOIN livres ON demande_livre.id=livres.id WHERE demande_livre.aprouver !='' AND demande_livre.aprouver !='Yes' AND demande_livre.username ='$_SESSION[login_user]' ORDER BY demande_livre.retour DESC";
        $res=mysqli_query($db,$sql);
        }

        echo " <br><br><br><br>";
        echo "<table class='table table-bordered' style='width:100%;' >";
        
        
        echo "<tr style='background-color: #6db6b9e6;'>";
        echo "<th>"; echo "Nom d'utilisateur";  echo "</th>";
        echo "<th>"; echo "Matricule";  echo "</th>";
        echo "<th>"; echo "ID";  echo "</th>";
        echo "<th>"; echo "Titre";  echo "</th>";
        echo "<th>"; echo "Auteur";  echo "</th>";
        echo "<th>"; echo "Édition";  echo "</th>";
        echo "<th>"; echo "Statut";  echo "</th>";
        echo "<th>"; echo "Date Emprunt";  echo "</th>";
        echo "<th>"; echo "Date Retour";  echo "</th>";

      echo "</tr>"; 
      echo "</table>";

       echo "<div class='scroll'>";
        echo "<table class='table table-bordered' >";
      while($row=mysqli_fetch_assoc($res))
      {
        echo "<tr>";
          echo "<td>"; echo $row['username']; echo "</td>";
          echo "<td>"; echo $row['roll']; echo "</td>";
          echo "<td>"; echo $row['id']; echo "</td>";
          echo "<td>"; echo $row['titre']; echo "</td>";
          echo "<td>"; echo $row['auteur']; echo "</td>";
          echo "<td>"; echo $row['maison_edition']; echo "</td>";
          echo "<td>"; echo $row['aprouver']; echo "</td>";
          echo "<td>"; echo $row['demande']; echo "</td>";
          echo "<td>"; echo $row['retour']; echo "</td>";
        echo "</tr>";
      }
    echo "</table>";
        echo "</div>";

    ?>
  </div>
</div>
</body>
</html>