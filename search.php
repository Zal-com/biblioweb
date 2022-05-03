<?php
session_start();

require 'config.php';

$message = '';
$books = [];

if(isset($_GET['btSearch'])) {
	if(!empty($_GET['author'])) {
		$author = $_GET['author'];
		
		//Enregistrer la recherche dans la session
		$_SESSION['lastSearches'][] = $author;
		
		if(sizeof($_SESSION['lastSearches'])>3) {
			array_shift($_SESSION['lastSearches']);	//Suppression du premier
		}
		
		//Connexion DB
		$link = mysqli_connect(HOSTNAME,USERNAME,PASSWORD,DATABASE);
		
		if($link) {
			$author = mysqli_real_escape_string($link, $author);
			
			$query = "SELECT * FROM books JOIN authors ON author_id=authors.id "
				."WHERE authors.lastname='$author' ORDER BY author_id";
			
			$result = mysqli_query($link, $query);
			
			if($result) {
				$books = mysqli_fetch_all($result, MYSQLI_ASSOC);
				
				mysqli_free_result($result);
				
				//Formatage de la liste des livres
				foreach($books as $book) {
					$final[$book['firstname']][] = $book;	//Ajouter
				}
				//['philip'=>[0,1,2,3]]['francis'=>[0]]
				$books = $final;
				unset($final);
			} else {
				$message = 'Erreur de requête.';
			}
			
			mysqli_close($link);
		} else {
			$message = 'Erreur de connexion.';
		}
		
		//echo '<pre>';	var_dump($_SESSION);	echo '</pre>';
	}	
}	

//echo '<pre>';	var_dump($books);	echo '</pre>';
?>
<?php require 'includes/header.php'; ?>
<form id="frmSearch" action="<?= $_SERVER['PHP_SELF']; ?>" method="get">
	<div>
		<input type="text" name="author">
		<button name="btSearch">Rechercher</button>
	</div>
</form>
<section>
<?php if(isset($author)) { ?>
	<h2>Résultats pour <em><?php echo htmlentities($author); ?></em></h2>
	
<?php foreach($books as $prenom => $livres) { ?>
	<div>
		<h3><?= "{$prenom} {$livres[0]['lastname']}" ?></h3>
		<ul>
		<?php foreach($livres as $livre) { ?>
			<li><?= $livre['title'] ?></li>
		<?php } ?>				
		</ul>
	</div>
<?php } //if ?>
<?php } //foreach ?>	
</section>
<div id="notification"><?= $message; ?></div>

<?php require 'includes/footer.php'; ?>