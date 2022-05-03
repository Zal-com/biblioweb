<?php
require 'config.php';

$step = 1;

function findUser(string $email) {
	//Accès DB
	$link = mysqli_connect(HOSTNAME,USERNAME,PASSWORD,DATABASE);

	if($link) {
		$safeEmail = mysqli_real_escape_string($link,$email);
		$query = "SELECT login FROM users WHERE email='$safeEmail'";
		$result = mysqli_query($link, $query);
		
		if($result) {
			$user = mysqli_fetch_assoc($result);
			mysqli_free_result($result);
			
			return $user;
		}
		
		mysqli_close($link);
	}
	
	return false;
}

if(isset($_GET['btResetPwd'])) {
	if(!empty($_GET['email'])) {
		$step = 1;
		$email = $_GET['email'];	//Piratage !!! injection SQL
		
		$user = findUser($email);
		
		if($user) {
			//Envoi de l'email
			$body = "<p>Vous recevez cet email car quelqu'un a fait une demande de "
				." récupération sur le site.</p>"
				.'<p><a href="password_reset.php?step=2">Réinitialisation du mot de passe</a></p>';
			
			// Pour envoyer un mail HTML, l'en-tête Content-type doit être défini
			$headers[] = 'MIME-Version: 1.0';
			$headers[] = 'Content-type: text/html; charset=iso-8859-1';

			//mail($email,"Mot de passe oublié",$body,$headers);
			
			$message = "Nous vous avon envoyé un mail à l'adresse ".
				"<em>".htmlspecialchars($email)."</em>";
			echo $body;	//DEBUG
		} else {
			$message = "Désolé, cet email ne correspond à aucun utilisateur.";
		}
	}
} elseif(isset($_GET['step']) && $_GET['step']==2) {
	$step = 2;
	
	//TODO Gestion du formulaire de modification du mot de passe
		//Requête UPDATE du password
		
		//Redirection vers formulaire de connexion
		//OU message d'erreur
}
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
	button { margin-top: 15px; }
</style>
</head>
<body>
<main class="container">
	<div class="row">
		<div class="col">
		<?php if($step==1) { ?>
		<h2>Récupérer mon mot de passe</h2>
		<p>Vous devez entrer votre email pour valider la demande.</p>
		<form action="<?= $_SERVER['PHP_SELF'] ?>" class="form-horizontal" method="get">
			<!-- Text input-->
			<div class="form-group">
			  <div class="col-md-4">
				<input id="email" name="email" type="email" placeholder="Entrez votre email" class="form-control input-md" required=""> 
			  </div>
			</div>

			<!-- Button -->
			<button id="btResetPwd" name="btResetPwd" class="btn btn-primary">Récupérer son mot de passe</button>
		</form>

		<?php if(!empty($message)) { ?>
		<p><?= $message ?></p>
		<?php } ?>
		<!-- Piratage Attaque XSS -->

		<?php } elseif($step==2) { ?>
		<h2>Réinitialiser mon mot de passe</h2>
		<p>Veuillez entrer votre nouveau mot de passe.</p>
		<form action="<?= $_SERVER['PHP_SELF'] ?>" class="form-horizontal" method="get">
			<!-- Text input-->
			<div class="form-group">
			  <div class="col-md-4">
				<input id="pwd" name="pwd" type="password" placeholder="Entrez votre nouveau mot de passe" class="form-control input-md" required=""> 
			  </div>
			</div>
			
			<div class="form-group">
			  <div class="col-md-4">
				<input id="pwd_conf" name="pwd_conf" type="password" placeholder="Confirmez votre nouveau mot de passe" class="form-control input-md" required=""> 
			  </div>
			</div>

			<!-- Button -->
			<button id="btSetNewPwd" name="btSetNewPwd" class="btn btn-primary">Modifier mon mot de passe</button>
		</form>
		<?php } ?>
		</div><!-- col -->
	</div><!-- row -->
</main>
</html>