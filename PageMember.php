<!DOCTYPE html>
<html lang="en">
<?php
$pdo = new PDO("mysql:host=localhost;dbname=onlinelibrary", 'root', '');
session_start();
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admine/styles.css">
    <title>bibliotheque </title>
</head>

<body>
    <div class="side-menu">
        <div class="brand-name">
            <h1><?php echo $_SESSION["nom"]; ?></h1>
        </div>
        <ul>
            <li><img src="admine/dashboard (2).png" alt="">&nbsp; <span><a href="PageMember.php" class="btn">Dashboard</a></span> </li>
            <li><img src="admine/settings.png" alt="">&nbsp;<span><a href="Emprunt.php" class="btn">Emprunt</a></span></li>
            <li><img src="admine/settings.png" alt="">&nbsp;<span><a href="livreDespo.php" class="btn">Livre Despo</a></span></li>
            <li><img src="admine/settings.png" alt="">&nbsp;<span><a href="modification.php" class="btn">Modifier</a></span></li>
            <li><img src="admine/settings.png" alt="">&nbsp;<span><a href="Avis et Notes.php" class="btn">Ajouter un Avis</a></span></li>
            <li><img src="admine/settings.png" alt="">&nbsp;<span><a href="logout.php" class="btn">Log out</a></span></li>
        </ul>
    </div>

    <div class="container">
        <div class="header">
            <div class="nav">
                <div class="search">
                    <input type="text" id="searchInput" onchange="searchBooks()" placeholder="Rechercher un livre...">
                    <button type="submit"><img src="admine/search.png" alt=""></button>
                </div>
                <div class="user">
                    <div class="img-case">
                        <img src="admine/user.png" alt="">
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
                            $sel = "SELECT COUNT(*) AS count FROM livres";
                            $sell = $pdo->prepare($sel);
                            $sell->execute();
                            $result = $sell->fetch(PDO::FETCH_ASSOC);
                            echo $result['count'];
                            ?>
                        </h1>
                        <h3>Livres</h3>
                    </div>
                    <div class="icon-case">
                        <img src="admine/teachers.png" alt="">
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
                            echo $result['count'];
                            ?>
                        </h1>
                        <h3>Emprunts</h3>
                    </div>
                    <div class="icon-case">
                        <img src="admine/schools.png" alt="">
                    </div>
                </div>
            </div>

            <div class="content-2">
                <div class="recent-payments">
                    <div class="title">
                        <h2>Liste des livres</h2>
                    </div>
                    <?php
                    $sql = "SELECT * FROM livres ORDER BY id_livre DESC";
                    $pdo_statement = $pdo->prepare($sql);
                    $pdo_statement->execute();
                    $result = $pdo_statement->fetchAll();
                    ?>
                    <table id="booksTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Titre</th>
                                <th>Auteur</th>
                                <th>Genre</th>
                                <th>Date Publication</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($result)) {
                                foreach ($result as $row) {
                            ?>
                                    <tr>
                                        <td><?php echo $row["id_livre"]; ?></td>
                                        <td><?php echo $row["titre"]; ?></td>
                                        <td><?php echo $row["auteur"]; ?></td>
                                        <td><?php echo $row["genre"]; ?></td>
                                        <td><?php echo $row["annee_publication"]; ?></td>
                                    </tr><?php
                                        }
                                    }
                                            ?>
                        </tbody>
                    </table>

                    </table>
                    <?php
                    $sql2 = "SELECT * FROM emprunts ORDER BY id_emprunt DESC";
                    $pdo_statement2 = $pdo->prepare($sql2);
                    $pdo_statement2->execute();
                    $resultT = $pdo_statement2->fetchAll();
                    ?>
                </div>
                <div class="new-students">
                    <div class="title">
                        <h2>Emprunt</h2>
                    </div>
                    <table>
                        <thead>
                            <th>id_livre</th>
                            <th>date_emprunt</th>
                            <th>Date_reture</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($resultT)) {
                                foreach ($resultT as $row) {
                            ?>
                                    <tr>

                                        <td><?php echo $row["id_livre"]; ?></td>
                                        <td><?php echo $row["date_emprunt"]; ?></td>
                                        <td><?php echo $row["date_retour"]; ?></td>

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

    <script src="index.js">

    </script>
</body>

</html>