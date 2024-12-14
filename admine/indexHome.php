<!DOCTYPE html>
<html lang="en">
<?php
    $pdo = new PDO("mysql:host=localhost;dbname=onlinelibrary", 'root','' );
       session_start();
 ?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>bibliotheque </title>
</head>

<body>
    <div class="side-menu">
        <div class="brand-name">
        <h1><?php echo "Admin";?></h1>
        </div>
        <ul>
            <li><img src="dashboard (2).png" alt="">&nbsp; <span><a href="indexHome.php" class="btn">Dashboard</a></span> </li>
            <li><img src="settings.png" alt="">&nbsp;<span><a href="emprunt.php" class="btn">Emprunts</a></span> </li>
            <li><img src="settings.png" alt="">&nbsp;<span><a href="gestionReture.php" class="btn">Gestion De Reture</a></span> </li>
            <li><img src="settings.png" alt="">&nbsp;<span><a href="/Gestion d’une Bibliothèque/STATIQUE/rapports.php" class="btn">STATIQUE</a></span> </li>
            <li><img src="settings.png" alt="">&nbsp;<span><a href="/Gestion d’une Bibliothèque/logout.php" class="btn">Log out</a></span> </li>
        </ul>
    </div>
    <div class="container">
        <div class="header">
            <div class="nav">
                <div class="search">
                    <input type="text" placeholder="Search..">
                    <button type="submit"><img src="search.png" alt=""></button>
                </div>
                <div class="user">
                    <a href="ajouterLivers.php" class="btn">Add Liver</a>
                    <div class="img-case">
                        <img src="user.png" alt="">
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="cards">
                <div class="card">
                    <div class="box">
                    <h1>
    <?php 
    $sel = "SELECT COUNT(*) AS count FROM members";
    $sell = $pdo->prepare($sel);
    $sell->execute();
    $result = $sell->fetch(PDO::FETCH_ASSOC);
    echo ($result['count']);
    ?>
</h1>
                        <h3>members</h3>
                    </div>
                    <div class="icon-case">
                        <img src="students.png" alt="">
                    </div>
                </div>
                <div class="card">
                    <div class="box">
                        <h1>
                        <?php 
    $sel = "SELECT COUNT(*) AS count FROM livres";
    $sell = $pdo->prepare($sel);
    $sell->execute();
    $result = $sell->fetch(PDO::FETCH_ASSOC);
    echo ($result['count']);
    ?>
                        </h1>
                        <h3>livres</h3>
                    </div>
                    <div class="icon-case">
                        <img src="teachers.png" alt="">
                    </div>
                </div>
                <div class="card">
                    <div class="box">
                        <h1>
                        <?php 
    $sel = "SELECT COUNT(*) AS count FROM emprunts";
    $sell = $pdo->prepare($sel);
    $sell->execute();
    $result = $sell->fetch(PDO::FETCH_ASSOC);
    echo ($result['count']);
    ?>
                        </h1>
                        <h3>emprunts</h3>
                    </div>
                    <div class="icon-case">
                        <img src="schools.png" alt="">
                    </div>
                </div>
                
            </div>
            <div class="content-2">
                <div class="recent-payments">
                    <div class="title">
                        <h2>Liste Des livres</h2>
                    </div>
                    <?php 
        $sql = "SELECT * FROM livres ORDER BY id_livre DESC";
        $pdo_statement = $pdo -> prepare($sql);
        $pdo_statement ->execute();
        $result = $pdo_statement -> fetchAll();
    ?>
                    <table>
                        <thead>
                        <tr>
                            <th>titre</th>
                            <th>auteur</th>
                            <th>genre</th>
                            <th>annee_publication</th>
                            <th>stock</th>
                            <th>option</th>
                        </tr>
                        </thead>
                        <tbody>
                      <?php  
                      if(!empty($result)){
                        foreach($result as $row){
                ?>
                <tr>
            <td><?php echo $row["titre"];?></td>
            <td><?php echo $row["auteur"];?></td>
            <td><?php echo $row["genre"];?></td>
            <td><?php echo $row["annee_publication"];?></td>
            <td><?php echo $row["stock"];?></td>
            <td style="text-align: center;"><a class="btn btn-primary" href='delLivers.php?id=<?php echo $row['id_livre']; ?>'>Supprimer</a> <a class="btn btn-danger" href='modifier.php?id=<?php echo $row['id_livre']; ?>'>Modifier</a> </td>
        </tr>
        <?php
            }
        }
        ?>

                        </tbody>
                        

                    </table>
                    <?php 
        $sql2 = "SELECT * FROM members ORDER BY id_membre DESC";
        $pdo_statement2 = $pdo -> prepare($sql2);
        $pdo_statement2 ->execute();
        $resultT = $pdo_statement2 -> fetchAll();
    ?>
                </div>
                <div class="new-students">
                    <div class="title">
                        <h2> members</h2>
                        <a href="AllMember.php" class="btn">View All</a>
                    </div>
                    <table>
                        <thead>
                        <tr>
                            <th>Profile</th>
                            <th>Name</th>
                            <th>option</th>
                        </tr>
                    </thead>
                    <tbody>
                   <?php  
                      if(!empty($resultT)){
                        foreach($resultT as $row){
                ?>
                        <tr>
                   
                            <td><img src="user.png" alt=""></td>
                            <td><?php echo $row["nom"];?></td>
                            <td style="text-align: center;">
                                <a class="btn btn-primary" href='/Gestion d’une Bibliothèque/delete.php?id=<?php echo $row['id_membre']; ?>'>Supprimer</a>
                                 </td>
                            </tr>

                        <?php
            }
        }
        ?>
                    </tbody>
                        
                       

                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>