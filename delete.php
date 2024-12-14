<?php 
    $pdo = new PDO( "mysql:host=localhost;dbname=onlinelibrary", 'root','' );
$sql = "delete from members where id_membre=" . $_GET['id'];
$pdo_statement=$pdo->prepare($sql);
$pdo_statement->execute();
header('location:admine/indexHome.php');
?>