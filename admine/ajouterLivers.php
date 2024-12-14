<?php
    $pdo = new PDO( "mysql:host=localhost;dbname=onlinelibrary", 'root','' );
    ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>The Easiest Way to Add Input Masks to Your Forms</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<?php 
if(isset($_POST['Submit'] )){
    $titre = $_POST['titre'];
    $auteur = $_POST['auteur'];
    $genre = $_POST['genre'];
    $anne = $_POST['anne'];
    $stock = $_POST['stock'];

    $sql = "CALL AjouterLivre('$titre', '$auteur','$genre','$anne','$stock')";
    $sql1 = $pdo -> prepare($sql);
    $result = $sql1 -> execute();
    if(isset($result)){
        header('location:indexHome.php');
    }else{
        echo 'errrrrrrrrrrrore';
    }


}
?>
<body>
    <div class="registration-form">
        <form method="post">
                <h1>Livers</h1>
            
            <div class="form-group">
                <input type="text" class="form-control item" name="titre" placeholder="titre" >
            </div>
            <div class="form-group">
                <input type="text" class="form-control item" name="auteur" placeholder="auteur">
            </div>
            <div class="form-group">
                <input type="text" class="form-control item" name="genre" placeholder="genre">
            </div>
            <div class="form-group">
                <input type="text" class="form-control item" name="anne"  id="birth-date" placeholder="annee_publication">
            </div>
            <div class="form-group">
                <input type="number" class="form-control item" name="stock" placeholder="stock">
            </div>
            <div class="form-group">
                <input type="submit" name="Submit"value="Submit" class="btn btn-dark">
            </div>
        </form>
        
    </div>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>
