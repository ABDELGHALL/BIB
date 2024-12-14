<?php
$pdo = new PDO("mysql:host=localhost;dbname=onlinelibrary", 'root', '');

if (isset($_POST['Submit'])) {
    if (!empty($_POST['id_livre']) && !empty($_POST['id_mombere']) && !empty($_POST['note'])) {
        $idlivre =$_POST['id_livre'];
        $idmombere =$_POST['id_mombere'];
        $commentaire = $_POST['commentaire']; 
        $note =$_POST['note'];

        $checkLivre = $pdo->query("SELECT COUNT(*) FROM livres WHERE id_livre = $idlivre");
        $livreExists = $checkLivre->fetchColumn();

        if ($livreExists > 0) {
            $sql = "INSERT INTO avis (id_livre, id_membre, commentaire, note) 
                    VALUES ('$idlivre', '$idmombere', '$commentaire', '$note')";
            $sql1 = $pdo->prepare($sql);
            $result = $sql1->execute();

            if ($result) {
                header('Location: PageMember.php');
                exit;
            }
        } else {
            $error_message = "Erreur : Le livre spécifié n'existe pas.";
        }
    }
}
?>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ajouter un Avis</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="admine/assets/css/style.css">
</head>
<body>
    <div class="registration-form">
        <form method="post">
            <h1>Ajouter un Avis</h1>
            
           <?php if (!empty($error_message)) : ?>
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
                <textarea name="commentaire" class="form-control item" placeholder="commentaire">
                </textarea>
            </div>
            <div class="form-group">
                <input type="number" class="form-control item" name="note" placeholder="note" max="5" min="0">
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
