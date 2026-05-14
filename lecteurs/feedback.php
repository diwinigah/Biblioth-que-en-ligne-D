<?php
include "../includes/db/connexion.php";
include"navbar.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>Suggestions</title>
 <style type="text/css">
    	body
    	{
    		background-image: url("images/livre-d-or.jpg");
            
    		background-repeat: no-repeat;
    	}
    	.wrapper
    	{
    		padding: 10px;
    		margin: -20px auto;
    		width:900px;
    		height: 600px;
    		background-color: black;
    		opacity: .8;
    		color: white;
    	}
    	.form-control
    	{
    		height: 70px;
    		width: 60%;
    	}
    	.scroll
    	{
    		width: 100%;
    		height: 300px;
    		overflow: auto;
    	}

    </style>
</head>
<body>

	<div class="wrapper">
		<h4>Si vous avez des suggestions ou des questions, merci de commenter ci-dessous.</h4>
		<form style="" action="" method="post">
			<input class="form-control" type="text" name="comment"  placeholder="Ecrivez vos suggestions..." ><br>	
			<input class="btn btn-default" type="submit" name="submit" value="Envoyer" style="width: 100px; height: 35px;">		
		</form>
	
<br><br>
	<div class="scroll">
		<?php
			if(isset($_POST['submit']))
			{
                $username = isset($_SESSION['login_user']) ? $_SESSION['login_user'] : 'Visiteur';
				$sql="INSERT INTO `comments` (username, comment) VALUES(?, ?)";
                $stmt = mysqli_prepare($db, $sql);
                mysqli_stmt_bind_param($stmt, "ss", $username, $_POST['comment']);
				if(mysqli_stmt_execute($stmt))
				{
					$q="SELECT * FROM `comments` ORDER BY `comments`.`id` DESC";
					$res=mysqli_query($db,$q);

				echo "<table class='table table-bordered'>";
					while ($row=mysqli_fetch_assoc($res)) 
					{
						echo "<tr>";
                            
                            echo "<td>"; echo htmlspecialchars($row['username']); echo "</td>";
							echo "<td>"; echo htmlspecialchars($row['comment']); echo "</td>";
						echo "</tr>";
					}
				echo "</table>";
				}

			}

			else
			{
				$q="SELECT * FROM `comments` ORDER BY `comments`.`id` DESC"; 
					$res=mysqli_query($db,$q);

				echo "<table class='table table-bordered'>";
					while ($row=mysqli_fetch_assoc($res)) 
					{
						echo "<tr>";
                            echo "<td>"; echo htmlspecialchars($row['username']); echo "</td>";
							echo "<td>"; echo htmlspecialchars($row['comment']); echo "</td>";
						echo "</tr>";
					}
				echo "</table>";
			}
		?>
	</div>
	</div>
</body>
</html>