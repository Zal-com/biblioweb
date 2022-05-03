<?php
//Inclusion
require 'config.php';

$message = '';


if(!empty($_GET['ref'])) {
	$ref = $_GET['ref'];
} elseif(!empty($_POST['ref'])) {
	if(!empty($_POST['title']) || !empty($_POST['description']) || !isset($_POST['cover_url']) || !isset($_POST['author_id'])) {
		
	} else {
		$message = 'Vous devez renseigner au moins un champ à modifier !';
	}
} else	{	//Redirection
	header('Location: dbaccess.php');
	header('HTTP/1.1 400 Bad Request');	//Bad request
	exit;
}


//Se connecter au serveur MySql
$mysqli = @mysqli_connect(HOSTNAME,USERNAME,PASSWORD);	//var_dump($mysqli);

if($mysqli) {
	//Sélectionner une base de données
	if(mysqli_select_db($mysqli, DATABASE)) {
		//Préparer une requête
		$query = "SELECT * FROM `books` INNER JOIN authors ON books.author_id=authors.id WHERE ref='$ref'";
		
		//Envoyer la requête
		$result = mysqli_query($mysqli, $query);	//var_dump($result);
		
		if($result) {
			//Extraire les résultats
			$livre = mysqli_fetch_assoc($result);
			//var_dump($lignes);
			
			if(empty($livre)) {	//Redirection
				header('Location: dbaccess.php');
				header('HTTP/1.1 404 Not Found');	//Livre non trouvé
				exit;
			}
			//Libérer la mémoire
			mysqli_free_result($result);
		} else {
			$message = 'Erreur de requête !';
		}
	} else {
		$message = 'Base de données inconnue !';
	}

	//Fermer la connection
	mysqli_close($mysqli);
} else {
	$message = 'Erreur de connexion !';
}
?>
<div><?= $message ?></div>
<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
	<div>
		<input type="hidden" name="ref" value="<?= $livre['ref'] ?>">
	</div>
	<div>
		<label>Titre</label>
		<input type="text" name="title" value="<?= $livre['title'] ?>">
	</div>
	<div>
		<label>Description</label>
		<input type="text" name="description" value="<?= $livre['description'] ?>">
	</div>
	<div>
		<label>Illustration</label>
		<input type="text" name="cover_url" value="<?= $livre['cover_url'] ?>">
	</div>
	<div>
		<label>Auteur</label>
		<select name="author_id">
			<option></option>
			<option value="4" selected>Philip K. Dick</option>
			<option value="1">Bob Sull</option>
			<option value="2">Fred Sull</option>
			<option value="3">Lydia Sull</option>
		</select>
	</div>
	<button>Modifier</button>
</form>










