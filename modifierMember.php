<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css" />
</head>
<body>
<?php
require('config.php');
session_start();

$id = $_GET['id'];

// Récupérer les informations du membre pour préremplir les champs
$member = null;
try {
    $stmt = $pdo->prepare("SELECT * FROM members WHERE id_membre = :id");
    $stmt->execute(['id' => $id]);
    $member = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

if (isset($_REQUEST['nom'], $_REQUEST['email'], $_REQUEST['telephone'], $_REQUEST['adresse'], $_REQUEST['password'])) {
    $nom = $_REQUEST['nom'];
    $email = $_REQUEST['email'];
    $telephone = $_REQUEST['telephone'];
    $adresse = $_REQUEST['adresse'];
    $password = $_REQUEST['password'];

    try {
        $query = "UPDATE members SET nom = '$nom', email = '$email', telephone = '$telephone', adresse = '$adresse', password = '$password' WHERE id_membre = '$id'";
        $res = $pdo->prepare($query);
        $result = $res->execute();

        if ($result) {
            header('location:admine/AllMember.php');
            exit;
        } else {
            echo "Failed to update user.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
<form class="box" action="" method="post">
    <h1 class="box-title">Edit</h1>
    <input type="text" class="box-input" name="nom" placeholder="Nom d'utilisateur" value="<?php echo htmlspecialchars($member['nom'] ?? ''); ?>" required />
    <input type="text" class="box-input" name="email" placeholder="Email" value="<?php echo htmlspecialchars($member['email'] ?? ''); ?>" required />
    <input type="tel" class="box-input" name="telephone" placeholder="Téléphone" value="<?php echo htmlspecialchars($member['telephone'] ?? ''); ?>" required />
    <textarea name="adresse" class="box-input" placeholder="Adresse" required><?php echo htmlspecialchars($member['adresse'] ?? ''); ?></textarea>
    <input type="password" class="box-input" name="password" placeholder="Mot de passe" value="<?php echo htmlspecialchars($member['password'] ?? ''); ?>" required />
    <input type="submit" name="submit" value="S'inscrire" class="box-button" />
</form>

</body>
</html>
