<?php
	session_start();
	if(!empty($_SESSION['auth']))
	{
		header('Location: index.php');
	}
?>
<!DOCTYPE html>
	<html>
		<head>
			<title>Connexion</title>
			<meta charset="UTF-8">
			<link rel="stylesheet" href="css/style.css">
			<link href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/3.3.7/lumen/bootstrap.min.css" rel="stylesheet">
			<link rel="stylesheet" href="css/css/font-awesome.css">
			<style>
				.icones
				{
					position:relative;
				}
				.form-control
				{
					width:500px;
					height:50px;
					margin-left:430px;
				}
				span.fa-user
				{
					position:absolute;
					top:10px;
					left:50px;
					margin-left:345px;
					margin-top:-6px;
				}
				span.fa-lock
				{
					position:absolute;
					top:10px;
					left:50px;
					margin-left:345px;
					margin-top:65px;
				}
			</style>
		</head>
		<body>
			<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav navbar-left">
					<li><a href="index.php">Nouveautés</a></li>
					<li><a href="register.php">Inscription</a></li>
				</ul>
			</div>
			<h1 style="text-align:center;margin-top:60px;">Connexion</h1>
			<div class="form-group icones" style="margin-top:50px;">
				<form method="POST">
					<span class="fa fa-user fa-3x" aria-hidden="true"></span>
					<input type="text" name="username" placeholder="Nom d'utilisateur" class="form-control">
					<br/>
					<span class="fa fa-lock fa-3x" aria-hidden="true"></span>
					<input type="password" name="password" placeholder="Mot de passe" class="form-control">
					<br/>
					<center><button type="submit" class="btn btn-success">Se connecter</button></center>
				</form>
			</div>
		</body>
	</html>
	<?php
		require_once 'function/boostrap.php';
		Database::Login($_POST);
	?>