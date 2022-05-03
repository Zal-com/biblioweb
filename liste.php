<?php
require 'config.php';

$books = [];
$title = "";

if(!empty($_GET['title'])) {
	$title = $_GET['title'];
} elseif(!empty($_POST['title'])) {
	$title = $_POST['title'];
}


$link = mysqli_connect(HOSTNAME,USERNAME,PASSWORD,DATABASE);
//var_dump($link);
mysqli_query($link, "SET NAMES utf8");

if(!empty($title)) {
	$title = mysqli_real_escape_string($link, $title);
	$query = "SELECT * FROM books WHERE title='$title'";
} else {
	$query = "SELECT * FROM books";
}

$result = mysqli_query($link, $query);
//var_dump($result);

if($result) {
	while(($book = mysqli_fetch_assoc($result))) {
		$books[] = $book;
	}
	//var_dump($books);
	
	$fields = mysqli_fetch_fields($result);
	//var_dump($fields);
	
	mysqli_free_result($result);
}

mysqli_close($link);

//Gestion des styles dynamiques
$filename = 'presets.json';
$styles = [];

if(file_exists($filename)) {
	$content = file_get_contents($filename);
	$json = json_decode($content,true);
	$styles = $json['homestyles'];
	
	//echo '<pre>';var_dump($styles);echo '</pre>';
}
?>
<!doctype html>
<html lang="fr">
<head>
<title>DB Access</title>
<meta charset="utf-8">
<style>
<?php
foreach($styles as $selector => $rules) {
	echo "$selector {\n";
	
	foreach($rules as $rule) {
		echo "\t$rule;\n";
	}
	
	echo "}\n";
}
?>
table { 
	margin: 15px 20px;
	border: 1px solid black;
	/* border-collapse: collapse; */
}

td, th {
	border: 1px solid silver; 
}

thead tr {
	background-color: silver;
}

tfoot tr {
	background-color: lightblue;
}

tr:nth-child(2n) {
	background-color: silver;
}

tfoot {
	text-align: center;
}
</style>
</head>
<body>
<p><a href="signin.php">Se connecter</a></p>
<ul>
	<li><a href="<?= $_SERVER['PHP_SELF']; ?>">Tous</a></li>
	<li><a href="?title=Ubik">Ubik</a></li>
	<li><a href="?title=Germinal">Germinal</a></li>
</ul>

<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
	<div>
		<label>Titre</label>
		<input type="text" name="title">
	</div>
	<button>Rechercher</button>
</form>


<table>
	<caption>Liste des livres</caption>
	<thead>
		<tr>
		<?php foreach($fields as $field) : ?>
			<th><?= ucfirst($field->name); ?></th>
		<?php endforeach; ?>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($books as $book) : ?>
		<tr>
			<td><?= $book['ref'] ?></td>
			<td><a class="book-title" href="show.php?ref=<?= $book['ref'] ?>"><?= $book['title'] ?></a></td>
			<td class="author"><?= $book['author_id'] ?></td>
			<td><?= substr($book['description'],0,20)."..." ?></td>
			<td><?php if(!empty($book['cover_url'])) : ?>
				<img src="<?= IMG_FOLDER.$book['cover_url'] ?>" alt="<?= $book['title'] ?>" height="80">
				<?php endif; ?>
			</td>
			<td>
				<form action="delete.php" method="post">
					<input type="hidden" name="method" value="DELETE">
					<input type="hidden" name="ref" value="<?= $book['ref'] ?>">
					<button class="ico-delete">&#9986;</button>
				</form>
				<span class="ico-edit">&#9998;</span>
			</td>
		</tr>
	<?php endforeach; ?>	
	</tbody>
	<tfoot>
		<tr><td colspan="5">&copy; EPFC &dot; 2021</td></tr>
	</tfoot>
</table>

</body>
</html>





