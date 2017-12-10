<?php
	session_start();
	session_unset($_SESSION['auth']);
	header('Location: index.php');
?>