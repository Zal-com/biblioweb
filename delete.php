<?php
require 'config.php';

//var_dump($_POST);

if(isset($_POST['ref']) && is_numeric($_POST['ref'])) {
	$link = mysqli_connect(HOSTNAME,USERNAME,PASSWORD,DATABASE);

	if($link) {
		$ref = mysqli_real_escape_string($link, $_POST['ref']);

		$query = "DELETE FROM `books` WHERE `books`.`ref` = $ref";
		$result = mysqli_query($link, $query);

		if($result && mysqli_affected_rows($link)>0) {
			$message = '<p class="success">Livre supprimé avec succès.</p>';
		} else {
			$message = '<p class="error">
				Erreur lors de la suppression.<br>'
				.mysqli_errno($link).' - '.mysqli_error($link)
			.'</p>';
		}

		mysqli_close($link);
	} else {
		$message = "Une erreur est survenue lors de la connexion au serveur.";
	}
} else {
	//Redirection
	header('Location: liste.php', 302);
	exit;
}
?>
<style>
.success {
	background-color: lightgreen;
	border-radius: 5px;
	border: 1px solid green;
	color: green;
	padding: 5px;
	text-align: center;
	width: 50%;
}

.error {
	background-color: pink;
	border-radius: 5px;
	border: 1px solid red;
	color: red;
	padding: 5px;
	text-align: center;
	width: 50%;
}
</style>
<body>
<div id="notification"><?= $message ?></div>
<nav><a href="liste.php">Retour à la liste</a></nav>
</body>