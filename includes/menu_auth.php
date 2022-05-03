<ul>
<?php if(empty($_SESSION['login'])) { ?>
	<li><a href="signin.php">Se connecter</a></li>
	<li><a href="signin.php">S'inscrire</a></li>
<?php } else { ?>
	<li><a href="signin.php?logout">Se déconnecter</a></li>
<?php } ?>
</ul>