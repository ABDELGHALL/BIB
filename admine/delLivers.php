<?php 
    $pdo = new PDO( "mysql:host=localhost;dbname=onlinelibrary", 'root','' );
$sql = "delete from livres where id_livre=" . $_GET['id'];
$pdo_statement=$pdo->prepare($sql);
$pdo_statement->execute();
header('location:indexHome.php');
?>