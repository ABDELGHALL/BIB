<?php
$pdo = new PDO("mysql:host=localhost;dbname=onlinelibrary", 'root', '');

if (isset($_POST['Submit'])) {
    $idlivre = $_POST['id_livre'];

    try {
        $sql = "SELECT VerifierDisponibilite($idlivre) AS statut";
        $sql1 = $pdo->prepare($sql);
        $sql1->execute();

        $result = $sql1->fetch(PDO::FETCH_ASSOC);

        if ($result['statut'] === "Disponible") {
            $success_message = "Le livre est disponible.";
        } else {
            $error_message = "Le livre n'est pas disponible.";
        }
    } catch (PDOException $e) {
        $error_message = "Une erreur est survenue : " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Livre Disponible</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="admine/assets/css/style.css">
</head>
<body>
    <div class="registration-form">
        <form method="post">
            <h1>Vérification Disponibilité</h1>
            
            <?php if (isset($success_message)) : ?>
                <div class="alert alert-success">
                    <?php echo $success_message; ?>
                </div>
            <?php elseif (isset($error_message)) : ?>
                <div class="alert alert-danger">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>
            
            <div class="form-group">
                <input type="text" class="form-control item" name="id_livre" placeholder="ID Livre" required>
            </div>
            <div class="form-group">
                <input type="submit" name="Submit" value="Vérifier" class="btn btn-dark">
                <a href="PageMember.php" class="btn btn-dark">Returne</a>
            </div>
        </form>
    </div>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>
