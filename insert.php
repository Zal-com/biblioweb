<meta charset="utf-8">
<?php
//Déclaration des variables et constantes
$message = '';
define('HOSTNAME','localhost');
define('USERNAME','root');
define('PASSWORD','root');
define('DATABASE','biblioweb');

//Traitement des commandes
if(isset($_POST['btAdd'])) {
	if(!empty($_POST['title']) && !empty($_POST['author_id'])) {
		if() {
			
		}
		
		if() {
			
		}
		
		//Cas normal
		$link = mysqli_connect(HOSTNAME,USERNAME,PASSWORD,DATABASE);
		//var_dump($link);
		mysqli_query($link, "SET NAMES utf8");

		$title = mysqli_real_escape_string($link, $title);
		$query = "SELECT * FROM books";

		$result = mysqli_query($link, $query);
		//var_dump($result);

		while(($book = mysqli_fetch_row($result))) {
			$books[] = $book;
		}
		var_dump($books);


		mysqli_free_result($result);

		mysqli_close($link);
	} else {
		$message = "Veuillez entrer le titre et l'auteur du livre!";
	}
}
?>

<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
	<div>
		<label for="title">Titre</label>
		<input type="text" name="title" id="title" placeholder="titre du livre" required>
	</div>
	<div>
		<label for="author_id">Auteur</label>
		<select name="author_id" id="author_id" required>
			<option></option>
			<option value="1">Guy Maupassant</option>
			<option value="2">Emile Zola</option>
		</select>
	</div>
	<div>
		<label for="description">Description</label>
		<textarea name="description" id="description" required></textarea>
	</div>
	<div>
		<label for="affiche">Affiche</label>
		<input type="text" name="affiche" id="affiche" required>
	</div>
	<button name="btAdd">Ajouter</button>
</form>
<p><?= $message; ?></p>


