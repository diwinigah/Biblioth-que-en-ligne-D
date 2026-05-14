<?php
	include "../includes/db/connexion.php";
	include "navbar.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title>Modifier le profil</title>
	<style type="text/css">
		.form-control
		{
			width:250px;
			height: 38px;
		}
		.form1
		{
			margin:0 540px;
		}
		label
		{
			color: white;
		}

	</style>
</head>
<body style="background-color: #004528;">

	<h2 style="text-align: center;color: #fff;">Modifier les informations</h2>
	<?php
		
	
		$sql = "SELECT * FROM lecteurs WHERE username=?";
		$stmt = mysqli_prepare($db, $sql);
		mysqli_stmt_bind_param($stmt, "s", $_SESSION['login_user']);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);

		// Initialisation des variables pour éviter les erreurs "Undefined variable"
		$first = "";
		$last = "";
		$username = "";
		$password = "";
		$email = "";
		$roll = "";
		$image = "default.png";

		while ($row = mysqli_fetch_assoc($result)) 
		{
			$first=$row['first'];
			$last=$row['last'];
			$username=$row['username'];
			$password=$row['password'];
			$email=$row['email'];
			$roll=$row['roll']; 
			$image=$row['image']; 
		}

	?>

	<div class="profile_info" style="text-align: center;">
		<span style="color: white;">Bienvenue,</span>	
		<h4 style="color: white;"><?php echo $_SESSION['login_user']; ?></h4>
	</div><br><br>
	
	<div class="form1">
		<form action="" method="post" enctype="multipart/form-data">

		<input class="form-control" type="file" name="file">

		<label><h4><b>Prénom : </b></h4></label>
		<input class="form-control" type="text" name="first" value="<?php echo htmlspecialchars($first); ?>">

		<label><h4><b>Nom :</b></h4></label>
		<input class="form-control" type="text" name="last" value="<?php echo htmlspecialchars($last); ?>">

		<label><h4><b>Nom d'utilisateur :</b></h4></label>
		<input class="form-control" type="text" name="username" value="<?php echo htmlspecialchars($username); ?>">

		<label><h4><b>Mot de passe :</b></h4></label>
		<input class="form-control" type="text" name="password" value="<?php echo htmlspecialchars($password); ?>">

		<label><h4><b>Email</b></h4></label>
		<input class="form-control" type="text" name="email" value="<?php echo htmlspecialchars($email); ?>">

		<label><h4><b>Matricule :</b></h4></label>
		<input class="form-control" type="text" name="roll" value="<?php echo htmlspecialchars($roll); ?>">

		<br>
		<div style="padding-left: 100px;">
			<button class="btn btn-default" type="submit" name="submit">Enregistrer</button></div>
	</form>
</div>
	<?php 

		if(isset($_POST['submit']))
		{
			$first=$_POST['first'];
			$last=$_POST['last'];
			$username=$_POST['username'];
			$password=$_POST['password'];
			$email=$_POST['email'];
			$roll=$_POST['roll'];
			
			if(!empty($_FILES['file']['name'])) {
				$pic = $_FILES['file']['name'];
				move_uploaded_file($_FILES['file']['tmp_name'],"images/".$pic);
				$sql1 = "UPDATE lecteurs SET image=?, first=?, last=?, username=?, password=?, email=?, roll=? WHERE username=?";
				$stmt1 = mysqli_prepare($db, $sql1);
				mysqli_stmt_bind_param($stmt1, "ssssssss", $pic, $first, $last, $username, $password, $email, $roll, $_SESSION['login_user']);
			} else {
				$pic = $image; 
				$sql1 = "UPDATE lecteurs SET first=?, last=?, username=?, password=?, email=?, roll=? WHERE username=?";
				$stmt1 = mysqli_prepare($db, $sql1);
				mysqli_stmt_bind_param($stmt1, "sssssss", $first, $last, $username, $password, $email, $roll, $_SESSION['login_user']);
			}

			if(mysqli_stmt_execute($stmt1))
			{
				
				$_SESSION['login_user'] = $username;
				$_SESSION['image'] = $pic;

				?>
					<script type="text/javascript">
						alert("Enregistré avec succès.");
						window.location="profile.php";
					</script>
				<?php
			}
		}
 	?>
</body>
</html>
