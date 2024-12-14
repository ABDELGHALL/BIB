<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="style.css" />
</head>
<body>
<?php
require('config.php');
session_start();

if (isset($_POST['nom'])){
	$nom = $_REQUEST['nom'];
	$password = $_REQUEST['password'];
	

    $query = "SELECT * FROM `members` WHERE nom='$nom' and password='$password'";
	$result = $pdo -> prepare($query);
	$res=$result -> execute();
	$user = $result->fetch();
	if($user){
	    $_SESSION['nom'] = $nom;
	    header("Location: PageMember.php");		
	}else{
		$message = "Le nom d'utilisateur ou le mot de passe est incorrect.";
	}
}
?>
<form class="box" action="" method="post" name="login">
<h1 class="box-title">Identification Etudiant</h1>
<input type="text" class="box-input" name="nom" placeholder="Nom d'utilisateur">
<input type="password" class="box-input" name="password" placeholder="Mot de passe">
<input type="submit" value="Connexion " name="submit" class="box-button">
<p class="box-register">Inscription Etudiant <a href="register.php">S'inscrire</a></p>
<p class="box-register">Identification Admin <a href="admin.php">S'inscrire</a></p>
<?php if (! empty($message)) { ?>
    <p class="errorMessage"><?php echo $message; ?></p>
<?php } ?>
</form>
</body>
</html>