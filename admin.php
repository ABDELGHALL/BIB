<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="style.css" />
</head>
<body>
<?php
require('config.php');
session_start();

if (isset($_POST['eid'])){
	$eid = $_REQUEST['eid'];
	$password = $_REQUEST['password'];
	

    $query = "SELECT * FROM `admin` WHERE eid='$eid' and password='$password'";
	$result = $pdo -> prepare($query);
	$res=$result -> execute();
	$admin = $result->fetch();
	if($admin){
	    $_SESSION['eid'] = $eid;
	    header("Location: admine/indexHome.php");		
	}else{
		$message = "Le nom d'utilisateur ou le mot de passe est incorrect.";
	}
}
?>
<form class="box" action="" method="post" name="login">
<h1 class="box-title">Identification Admin</h1>
<input type="text" class="box-input" name="eid" placeholder="eid">
<input type="password" class="box-input" name="password" placeholder="Mot de passe">
<input type="submit" value="Connexion " name="submit" class="box-button">
<p class="box-register"><a href="login.php">Page d'Acceuil</a></p>
<?php if (! empty($message)) { ?>
    <p class="errorMessage"><?php echo $message; ?></p>
<?php } ?>
</form>
</body>
</html>