<?php
session_start();

require 'secure.php';

$user = [
	'login' => 'ced',
	'email' => 'ceruth@epfc.eu',
	'statut' => 'admin',
	'created_at' => '2007-06-21 00:00:00',
	'photo' => 'images/users/ced.jpg',
];
?>
<!doctype html>
<html lang="fr">
<head>
<title>DB Access</title>
<meta charset="utf-8">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
<style>
	.col { border:1px solid silver; padding: 15px; }
	.col:nth-child(2) { background-color: black; color: white; }
	figure { float: right; }
</style>
</head>
<body>
<main class="container">
	<div class="row">
		<div class="col">
			<h2>Profil de <?= $user['login']; ?></h2>
			<figure>
				<img src="<?= $user['photo']; ?>" alt="<?= $user['login']; ?>" width="200">
				<figcaption><?= $user['login']; ?></figcaption>
			</figure>
			<table>
				<tr><th>Login</th><td><?= $user['login']; ?></td></tr>
				<tr><th>Email</th><td><?= $user['email']; ?></td></tr>
				<tr><th>Statut</th><td><?= $user['statut']; ?></td></tr>
				<tr><th>Inscrit le</th><td><?= $user['created_at']; ?></td></tr>
			</table>
			<p><a href="change_password.php">Changer le mot de passe</a></p>
		</div><!-- col -->
	</div><!-- row -->
</main>
</html>