<?php
$pdo = new PDO("mysql:host=localhost;dbname=onlinelibrary", 'root', '');

$id = $_GET['id'];

$livre = null;
try {
    $stmt = $pdo->prepare("SELECT * FROM livres WHERE id_livre = :id");
    $stmt->execute(['id' => $id]);
    $livre = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

if (isset($_POST['Submit'])) {
    $titre = $_POST['titre'];
    $auteur = $_POST['auteur'];
    $genre = $_POST['genre'];
    $anne = $_POST['anne'];
    $stock = $_POST['stock'];

    try {
        $query = "UPDATE livres SET titre = '$titre', auteur = '$auteur', genre = '$genre', annee_publication = '$anne', stock = '$stock' WHERE id_livre = '$id'";
        $stmt = $pdo->prepare($query);
        $result = $stmt->execute();
        if ($result) {
            header('Location: indexHome.php');
            exit;
        } else {
            echo "Échec de la mise à jour du livre.";
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mise à jour du livre</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="registration-form">
        <form method="post">
            <h1>Livre</h1>

            <div class="form-group">
                <input type="text" class="form-control item" name="titre" placeholder="Titre" value="<?php echo $livre['titre'] ; ?>">
            </div>
            <div class="form-group">
                <input type="text" class="form-control item" name="auteur" placeholder="Auteur" value="<?php echo $livre['auteur']; ?>">
            </div>
            <div class="form-group">
                <input type="text" class="form-control item" name="genre" placeholder="Genre" value="<?php echo $livre['genre'] ; ?>">
            </div>
            <div class="form-group">
                <input type="text" class="form-control item" name="anne" id="birth-date" placeholder="Année de publication" value="<?php echo $livre['annee_publication']; ?>">
            </div>
            <div class="form-group">
                <input type="number" class="form-control item" name="stock" placeholder="Stock" value="<?php echo $livre['stock'] ; ?>">
            </div>
            <div class="form-group">
                <input type="submit" name="Submit" value="Soumettre" class="btn btn-dark">
            </div>
        </form>
    </div>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>
