<?php
	require_once 'function/boostrap.php';
	$db = App::getDatabase();
?>
<!DOCTYPE html>
	<html>
		<head>
			<title>Nouveautés</title>
			<meta charset="UTF-8">
			<link rel="stylesheet" href="css/style.css">
			<link href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/3.3.7/lumen/bootstrap.min.css" rel="stylesheet">
		</head>
		<body>
			<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav navbar-left">
					<li><a href="register.php">Inscription</a></li>
					<li><a href="login.php">Connexion</a></li>
				</ul>
			</div>
			<h1 style="text-align:center;margin-top:60px;">Nouveautés</h1>
			<br/> <br/>
			<?php 
				$req = $db->query("SELECT * FROM news ORDER BY id DESC");
		while($news = $req->fetch(PDO::FETCH_ASSOC)): ?>
			<div class="panel">
					<p class="information"><img class="information" src="<?= $news['image']; ?>" alt="news" style="width:100px;height:100px;"/> <?= $news['message']; ?></p>
			</div>
		<?php endwhile; ?>
		</body>
	</html>