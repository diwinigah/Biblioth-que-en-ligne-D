<?php 
include "navbar.php";
include "../includes/db/connexion.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
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
	margin: 0px auto;
	opacity: .8;
	color: white;
	padding: 20px ;
}
    label{
      font-size: 15px;
      font-weight: 600px;
    }
    header
    {
      width: 300%;
    }
  </style> 
</head>
<body>


    <section>
        <div class="log_img">
             <br><br><br>
                    <div class="box1">
                            <h2 style="text-align: center; font-size: 27px; font-family: lucida console;"> Système de gestion des bibliothèques </h2><br>
                                <h2 style="text-align: center; font-size: 22px; font-family: lucida console;">Formulaire de connexion utilisateur</h2>
                                 <br>
                          
                           <form  name="login" action="" method="post">
                            <b><p style="padding-left: 50px; font-size: 15px; font-weight: 700;">Se connecter en tant que :</p></b>
                            <br>
                            
                            <input style="margin-left: 50px; width: 18px;" type="radio" name="user" id="admin" value="admin">
                            <label for="admin" >Admin</label>
                            <input style="margin-left: 50px; width: 18px;" type="radio" name="user" id="lecteurs" value="lecteurs" checked="">
                            <label for="lecteurs" >Lecteur</label>
                            
                            
                            <div class="login">
                                    <input  class="form-control" type="text" name="username" placeholder="Nom d'utilisateur" required=""><br>
                                    <input class="form-control" type="password" name="password" placeholder="Mot de passe" required=""><br>
                                    <input class="btn btn-default" type="submit" name="submit" value="Se connecter" style="color:black; width:100px; height:30px;">
                            </div> 
                          
                           
                             <p style="color: white; padding-left: 15px;">
        <br><br>
        <a id="forgot_link" style="color: yellow;" href="update_password.php?user=lecteurs">Mot de passe oublié ?</a> 
         Nouveau sur le site ?<a style="color: yellow;" href="registration.php">Inscrivez-vous</a>
      </p>
                            </form>
                 </div>
        </div>

    </section>
<?php
       if(isset($_POST["submit"]))
        {
          if(!isset($_POST['user']))
          {
            ?>
            <div class="alert alert-danger" style="width: 550px; margin-left: 320px; background-color: red; color: white;"><strong>Veuillez sélectionner un type d'utilisateur.</strong></div>
            <?php
          }
          else
          if($_POST["user"]=='admin')
          {
              $count=0;
      
      $sql = "SELECT * FROM `admin` WHERE username=? AND password=?";
      $stmt = mysqli_prepare($db, $sql);
      mysqli_stmt_bind_param($stmt, "ss", $_POST['username'], $_POST['password']);
      mysqli_stmt_execute($stmt);
      $res = mysqli_stmt_get_result($stmt);
      
      $row = mysqli_fetch_assoc($res);
      $count = mysqli_num_rows($res);

      if($count==0)
      {
        ?>
             
          <div class="alert alert-danger" style="width: 600px; margin-left: 370px; background-color: #de1313; color: white">
            <strong>Le nom d’utilisateur et le mot de passe ne correspondent pas.</strong>
          </div>    
        <?php
      }
      else
      {

        $_SESSION['login_user'] = $_POST['username']; 
        $_SESSION['image'] = $row['image'];


        ?>
          <script type="text/javascript">
            window.location="admis/index.php"
          </script>
        <?php
      }
          }else
          {

        $count=0;
        $sql = "SELECT * FROM lecteurs WHERE username=? AND password=?";
        $stmt = mysqli_prepare($db, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $_POST['username'], $_POST['password']);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($res);
        $count = mysqli_num_rows($res);
        
       if($count==0){
        ?>
                      <div class="alert alert-danger" style="width: 550px; margin-left: 320px; background-color: red; color: white";>
                        <strong> Le nom d’utilisateur et le mot de passe ne correspondent pas.</strong>
                      </div>
        <?php
        
       }else{
             $_SESSION["login_user"]= $_POST["username"];
              $_SESSION['image'] = $row['image'];

        ?>
           <script type="text/javascript">
            window.location="index.php"
         </script>
        <?php

       }
        }
      }
       ?>
<script type="text/javascript">
  $(document).ready(function(){
    // Fonction pour mettre à jour le lien en fonction du bouton radio coché
    function updateLink() {
        var userType = $('input[name="user"]:checked').val();
        $('#forgot_link').attr('href', 'update_password.php?user=' + userType);
    }

   
    $('input[name="user"]').change(updateLink);
    updateLink(); 
  });
</script>
</body>
</html>