<?php
	session_start();
	require_once 'config.php';
	if(!empty($_SESSION['auth']))
	{
		header('Location: index.php');
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Inscription</title>
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
			span.fa-unlock
			{
				position:absolute;
				top:10px;
				left:50px;
				margin-left:340px;
				margin-top:135px;
			}
			span.fa-envelope-o
			{
				position:absolute;
				top:10px;
				left:50px;
				margin-left:335px;
				margin-top:200px;
			}
		</style>
	</head>
	<body>
		<div class="collapse navbar-collapse">
			<ul class="nav navbar-nav navbar-left">
				<li><a href="index.php">Nouveautés</a></li>
				<li><a href="login.php">Connexion</a></li>
			</ul>
		</div>
		<h1 style="text-align:center;">Inscription</h1>
		<form method="POST">
			<div class="form-group icones" style="margin-top:50px;">
				<span class="fa fa-user fa-3x" aria-hidden="true"></span>
				<input type="text" name="username" placeholder="Nom d'utilisateur" class="form-control">
				<br/>
				<span class="fa fa-lock fa-3x" aria-hidden="true"></span>
				<input type="password" name="password" placeholder="Mot de passe" class="form-control">
				<br/>
				<span class="fa fa-unlock fa-3x" aria-hidden="true"></span>
				<input type="password" name="password_co" placeholder="Confirmer votre mot de passe" class="form-control">
				<br/>
				<span class="fa fa-envelope-o fa-3x" aria-hidden="true"></span>
				<input type="email" name="email" placeholder="Votre adresse email" class="form-control">
				<br/>
				<div class="g-recaptcha" data-sitekey="<?= $publicKey; ?>"></div>
				<br/>
				<center><button type="submit" class="btn btn-success">M'inscrire</button></center>
			</div>
		</form>
	</body>
</html>
<?php
	require_once 'function/boostrap.php';
	Database::Register($_POST);
?>