<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css" />
</head>
<body>
<?php
require('config.php');
if (isset($_REQUEST['nom'], $_REQUEST['email'], $_REQUEST['telephone'], $_REQUEST['adresse'], $_REQUEST['password'])) {
    $nom = $_REQUEST['nom'];
    $email = $_REQUEST['email'];
    $telephone = $_REQUEST['telephone'];
    $adresse = $_REQUEST['adresse'];
    $password = $_REQUEST['password'];

    $query = "INSERT INTO `members` (nom, email, telephone, adresse, password)
              VALUES ('$nom', '$email', '$telephone', '$adresse', '$password')";

    $res = $pdo->prepare($query);
    $result = $res->execute();

    if ($result) {
        echo "<div class='sucess'>
                <h3>Vous êtes inscrit avec succès.</h3>
                <p>Cliquez ici pour vous <a href='login.php'>connecter</a></p>
              </div>";
    }
} else {
?>
<form class="box" action="" method="post">
    <h1 class="box-logo box-title">DEV 204</h1>
    <h1 class="box-title">S'inscrire</h1>
    <input type="text" class="box-input" name="nom" placeholder="Nom d'utilisateur" required />
    <input type="text" class="box-input" name="email" placeholder="Email" required />
    <input type="tel" class="box-input" name="telephone" placeholder="Téléphone" required />
    <textarea name="adresse" class="box-input" placeholder="Adresse"></textarea>
    <input type="password" class="box-input" name="password" placeholder="Mot de passe" required />
    <input type="submit" name="submit" value="S'inscrire" class="box-button" />
    <p class="box-register">Déjà inscrit? <a href="login.php">Connectez-vous ici</a></p>
</form>
<?php } ?>
</body>
</html>
