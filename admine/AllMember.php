<?php
    $pdo = new PDO("mysql:host=localhost;dbname=onlinelibrary", 'root','' );
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Document</title>
</head>
<body>
    <?php 
        $sql = "SELECT * FROM members ORDER BY id_membre DESC";
        $pdo_statement = $pdo -> prepare($sql);
        $pdo_statement ->execute();
        $result = $pdo_statement -> fetchAll();
    ?>

<div class="container mt-3">
  <h2>Listes Des Members </h2>  
  <div class="row mt-3">
    <div class="col-3"><a href="indexHome.php" class="btn btn-danger">Returne</a></div>
  
</div>         
  <table class="table table-striped table-bordered mt-3">
    <thead>
      <tr>
        <th width="15%">nom</th>
        <th width="15%">email</th>
        <th width="15%">telephone</th>
        <th width="15%">adresse</th>
        <th width="15%">password</th>
        <th width="20%">Action</th>
      </tr>
    </thead>
    <tbody>
        <?php 
        if(!empty($result)){
            foreach($result as $row){
                ?>
        <tr>
            <td><?php echo $row["nom"];?></td>
            <td><?php echo $row["email"];?></td>
            <td><?php echo $row["telephone"];?></td>
            <td><?php echo $row["adresse"];?></td>
            <td><?php echo $row["password"];?></td>
            <td style="text-align: center;"><a class="btn btn-primary" href='/Gestion d’une Bibliothèque/delete.php?id=<?php echo $row['id_membre']; ?>'>Supprimer</a> <a class="btn btn-danger" href='/Gestion d’une Bibliothèque/modifierMember.php?id=<?php echo $row['id_membre']; ?>'>Modifier</a> </td>
        </tr>
        <?php
            }
        }
        ?>
    </tbody>
    </table>
</div>
</body>
</html>