<?php
$pdo = new PDO("mysql:host=localhost;dbname=onlinelibrary", 'root', '');

if (isset($_POST['Submit'])) {
    $idlivre = $_POST['id_livre'];
    $idmombere = $_POST['id_mombere'];
    $date = $_POST['date'];

    try {
        $sql = "CALL ReserverLivre('$idlivre', '$idmombere', '$date')";
        $sql1 = $pdo->prepare($sql);
        $result = $sql1->execute();
        
        if ($result) {
            header('location:PageMember.php');
            exit;
        }
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), "Le livre n'est pas disponible") !== false) {
            $error_message = "Erreur : Le livre demandé n'est pas disponible.";
        } else {
            $error_message = "Une erreur est survenue : " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Emprunt</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="admine/assets/css/style.css">
</head>
<body>
    <div class="registration-form">
        <form method="post">
            <h1>Emprunt</h1>
            
            <?php if (isset($error_message)) : ?>
                <div class="alert alert-danger">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>
            
            <div class="form-group">
                <input type="text" class="form-control item" name="id_livre" placeholder="Id Livre">
            </div>
            <div class="form-group">
                <input type="text" class="form-control item" name="id_mombere" placeholder="Id Membere">
            </div>
            <div class="form-group">
                <input type="date" class="form-control item" name="date" id="birth-date" placeholder="Date Emprunt">
            </div>
            <div class="form-group">
                <input type="submit" name="Submit" value="Submit" class="btn btn-dark">
            </div>
        </form>
    </div>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>
