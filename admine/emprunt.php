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
    <title>Listes Des Emprunt</title>
</head>
<body>
    <?php 
        $sql = "SELECT * FROM emprunts ORDER BY id_emprunt DESC";
        $pdo_statement = $pdo -> prepare($sql);
        $pdo_statement ->execute();
        $result = $pdo_statement -> fetchAll();
    ?>

<div class="container mt-3">
  <h2>Listes Des Emprunt </h2>  
  <div class="row mt-3">
    <div class="col-3"><a href="indexHome.php" class="btn btn-danger">Returne</a></div>
  
</div>         
  <table class="table table-striped table-bordered mt-3">
    <thead>
      <tr>
        <th width="15%">id_emprunt</th>
        <th width="15%">id_livre</th>
        <th width="15%">id_membre</th>
        <th width="15%">date_emprunt</th>
        <th width="15%">date_retour</th>
        <th width="20%">Action</th>
      </tr>
    </thead>
    <tbody>
        <?php 
        if(!empty($result)){
            foreach($result as $row){
                ?>
        <tr>
            <td><?php echo $row["id_emprunt"];?></td>
            <td><?php echo $row["id_livre"];?></td>
            <td><?php echo $row["id_membre"];?></td>
            <td><?php echo $row["date_emprunt"];?></td>
            <td><?php echo $row["date_retour"];?></td>
            <td style="text-align: center;"><a class="btn btn-primary" href='/Gestion d’une Bibliothèque/delete.php?id=<?php echo $row['id_membre']; ?>'>Supprimer</a> <a class="btn btn-danger" href='modifier.php?id=<?php echo $row['id']; ?>'>Modifier</a> </td>
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