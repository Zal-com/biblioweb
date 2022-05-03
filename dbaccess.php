<?php
//Inclusion
require 'config.php';

//Déclaration des variables et constantes
$message = '';
$livres = [];
$keyword = '';

//Traitement des commandes
if(!empty($_GET['keyword'])) {
	$keyword = $_GET['keyword'];
}

//Se connecter au serveur MySql
$mysqli = @mysqli_connect(HOSTNAME,USERNAME,PASSWORD);	//var_dump($mysqli);

if($mysqli) {
	//Sélectionner une base de données
	if(mysqli_select_db($mysqli, DATABASE)) {
		//Préparer une requête
		if(empty($keyword)) {
			$query = "SELECT * FROM `books`";
		} else {
			$query = "SELECT * FROM `books` WHERE title LIKE '%$keyword%'";
		}
		
		//Envoyer la requête
		$result = mysqli_query($mysqli, $query);	//var_dump($result);
		
		if($result) {
			//Extraire les résultats
			while(($ligne = mysqli_fetch_assoc($result)) != null) {
				$livres[] = $ligne;
			}
			//var_dump($lignes);
			
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
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Biblioweb :: DB Access</title>
</head>
<body>
<div><?= $message ?></div>

<form action="<?= $_SERVER['PHP_SELF'] ?>" method="get">
	<input type="text" name="keyword" placeholder="Titre du livre">
	<button>Rechercher</button>
</form>

<section id="liste">
<?php foreach($livres as $livre) { ?>
	<article>
		<h2><?= $livre['title'] ?></h2>
		<figure>
			<img src="<?= $livre['cover_url'] ?>" alt="<?= $livre['title'] ?>" width="100">
			<figcaption><?= $livre['title'] ?></figcaption>
		</figure>
		<p><?= $livre['description'] ?></p>
		<p><a href="edit.php?ref=<?= $livre['ref'] ?>">Modifier</a></p>
	</article>
<?php } ?>
</section>
</body>
</html>










