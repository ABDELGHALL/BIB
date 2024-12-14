<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
<?php
require('config.php');

if (isset($_POST['nom'], $_POST['email'], $_POST['telephone'], $_POST['adresse'], $_POST['password'], $_GET['id'])) {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $adresse = $_POST['adresse'];
    $password = $_POST['password'];
    $id = $_GET['id'];

    try {

        $query = "UPDATE members set nom = '$nom', email = '$email', telephone = '$telephone', adresse = '$adresse', password = '$password' where id_membre='$id'";
        $res = $pdo->prepare($query);
        $result = $res->execute();
    
        if($result) {
            header('location: PageMember.php');
            exit;
        } else {
            echo "Failed to update user.";
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    
    session_start();
}
?>

<form class="box" action="" method="post">
    <h1 class="box-logo box-title">Edit</h1>
    <input type="text" class="box-input" name="nom" placeholder="Nom d'utilisateur" value="<?php echo isset($_SESSION['nom']) ? $_SESSION['nom'] : ''; ?>" required />
    <input type="email" class="box-input" name="email" placeholder="Email" value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>" required />
    <input type="tel" class="box-input" name="telephone" placeholder="Téléphone" value="<?php echo isset($_SESSION['telephone']) ? $_SESSION['telephone'] : ''; ?>" required />
    <textarea name="adresse" class="box-input" placeholder="Adresse" required><?php echo isset($_SESSION['adresse']) ? $_SESSION['adresse'] : ''; ?></textarea>
    <input type="password" class="box-input" name="password" placeholder="Mot de passe" required />
    <input type="submit" name="submit" value="S'inscrire" class="box-button" />
</form>

</body>
</html>
