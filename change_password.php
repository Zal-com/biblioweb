<?php
session_start();
require 'config.php';

require 'includes/header.php';

$message = "";

if(isset($_POST['btChangePwd'])) {
	if(!empty($_POST['pwd']) && !empty($_POST['pwd_conf'])) {	//Verifier la présence des champs obligatoires
		$pwd = $_POST['pwd'];
		$pwdConf = $_POST['pwd_conf'];
		
		if($pwd == $pwdConf) {	//Comparer les deux mots de passe
			$link = mysqli_connect(HOSTNAME,USERNAME,PASSWORD,DATABASE);
			
			if($link) {
				$pwd = password_hash($pwd, PASSWORD_BCRYPT);		
				
				$query = "UPDATE `users` SET `password`='$pwd' WHERE login='{$_SESSION['login']}'";
				
				$result = mysqli_query($link, $query);
				
				if($result && mysqli_affected_rows($link)==1) {
					$_SESSION['message'] = '<span class="alert alert-success">Modification réussie.</span>';
					
					//redirection
					header('Location: index.php');
					header('Status: 302');
					exit;
				} else {
					$message = '<span class="alert alert-danger">Erreur de modification. Mot de passe inchangé.</span>';
				}
			} else {
				$message = '<span class="alert alert-danger">Une erreur s\'est produite lors de la connexion au serveur.</span>';
			}
		} else {
			$message = '<span class="alert alert-danger">La confirmation du mot de passe ne correspond pas.</span>';
		}
	} else {
		$message = '<span class="alert alert-danger">Veuillez remplir tous les champs obligatoires.</span>';
	}
}
?>
	<div class="row">
		<div class="col">
			<h2>Changement de mot de passe</h2>
			
			<form class="form-horizontal" action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
				<fieldset>

					<!-- Form Name -->
					<legend>Changement de mot de passe</legend>

					<!-- Password input-->
					<div class="form-group">
					  <label class="col-md-8 control-label" for="pwd">Password</label>
					  <div class="col-md-8">
						<input id="pwd" name="pwd" type="password" placeholder="Entrez votre mot de passe" class="form-control input-md" required="">
						<span class="help-block">Entrez votre mot de passe</span>
					  </div>
					</div>
					
					<div class="form-group">
					  <label class="col-md-8 control-label" for="pwd">Password Confirm</label>
					  <div class="col-md-8">
						<input id="pwd_conf" name="pwd_conf" type="password" placeholder="Confirmez votre nouveau mot de passe" class="form-control input-md" required=""> 
					  </div>
					</div>
					
					<button name="btChangePwd" class="btn btn-primary">Modifier</button>
				</fieldset>
			</form>
			<div id="notification"><p><?= $message; ?></p></div>
		</div><!-- col -->
	</div><!-- row -->
<?php
require 'includes/footer.php';
?>