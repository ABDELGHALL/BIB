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
    $date_reture = $_POST['date_reture'];
    $id_emprunt = $_POST['id_emprunt'];
    

    $sql = "CALL GererRetour('$id_emprunt','$date_reture')";
    $sql1 = $pdo -> prepare($sql);
    $result = $sql1 -> execute();
    if(isset($result)){
        header('location:emprunt.php');
    }else{
        echo 'errrrrrrrrrrrore';
    }


}
?>
<body>
    <div class="registration-form">
        <form method="post">
                <h1>Gestion De Reture</h1>
            
          
            <div class="form-group">
                <input type="text" class="form-control item" name="id_emprunt" placeholder="id_emprunt">
            </div>
            
            <div class="form-group">
                <input type="date" class="form-control item" name="date_reture"   placeholder="date Emprunte">
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
