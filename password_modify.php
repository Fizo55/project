<?php
	session_start();
	if(empty($_SESSION['auth']))
	{
		header('Location: index.php');
	}
?>
<!DOCTYPE html>
	<html>
		<head>
			<title>Modifier mot de passe</title>
			<meta charset="UTF-8">
			<link rel="stylesheet" href="css/style.css">
			<link href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/3.3.7/lumen/bootstrap.min.css" rel="stylesheet">
			<link rel="stylesheet" href="css/css/font-awesome.css">
			<style>
				.form-control
				{
					width:500px;
					height:50px;
					margin-left:430px;
				}
				.icones
				{
					position:relative;
				}
				span.fa-lock
				{
					position:absolute;
					top:10px;
					left:50px;
					margin-left:345px;
					margin-top:-5px;
				}
				span.fa-unlock
				{
					position:absolute;
					top:10px;
					left:50px;
					margin-left:340px;
					margin-top:65px;
				}
			</style>
		</head>
		<body>
			<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav navbar-left">
					<li><a href="index.php">Nouveautés</a></li>
					<li><a href="logout.php">Déconnexion</a></li>
				</ul>
			</div>
			<h1 style="text-align:center;margin-top:60px;">Modifier votre mot de passe</h1>
			<form method="POST">
				<div class="form-group icones" style="margin-top:50px;">
					<span class="fa fa-lock fa-3x" aria-hidden="true"></span>
					<input type="password" name="password" placeholder="Mot de passe" class="form-control">
					<br/>
					<span class="fa fa-unlock fa-3x" aria-hidden="true"></span>
					<input type="password" name="password_co" placeholder="Confirmer votre mot de passe" class="form-control">
					<br/>
					<center><button type="submit" class="btn btn-success">Changer mon mot de passe</button></center>
				</div>
			</form>
		</body>
	</html>
	<?php
		require_once 'function/boostrap.php';
		Database::ModifyPassword($_POST);
	?>