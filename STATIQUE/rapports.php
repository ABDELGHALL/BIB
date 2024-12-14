<?php
$conn = new PDO("mysql:host=localhost;dbname=onlinelibrary", 'root', '');

// Vérifier si le formulaire a été soumis et l'alerte doit être affichée
$showAlert = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $memberId = $_POST['memberId'];
    $bookTitle = $_POST['bookTitle'];
    $showAlert = true;
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StatistiQues</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: white;
            padding: 10px 0;
            text-align: center;
        }

        h2 {
            color: #333;
            margin-top: 20px;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: white;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        footer {
            text-align: center;
            padding: 10px;
            background-color: #333;
            color: white;
            position: absolute;
            width: 100%;
            bottom: 0;
        }
    </style>
</head>

<body>
    <header>
        <h1>StatistiQues</h1>
        <a href="/Gestion d’une Bibliothèque/admine/indexHome.php" class="btn btn-primary">Retour</a>
    </header>

    <div class="content">
        <?php
        $sql = "SELECT livres.titre AS Livre, COUNT(emprunts.id_emprunt) AS Nombre_emprunts
                FROM emprunts
                JOIN livres ON emprunts.id_livre = livres.id_livre
                GROUP BY livres.titre
                ORDER BY Nombre_emprunts DESC";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <h1>Livres les plus empruntés</h1>
        <table>
            <thead>
                <tr>
                    <th>Livre</th>
                    <th>Nombre d'emprunts</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($rows as $row) { ?>
                    <tr>
                        <td><?php echo $row['Livre']; ?></td>
                        <td><?php echo $row['Nombre_emprunts']; ?></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>

        <?php
        $sql = "SELECT members.id_membre AS Membre_ID, members.nom AS Membre, livres.id_livre AS Livre_ID, livres.titre AS Livre, emprunts.date_emprunt AS Date_Emprunt,
                emprunts.date_retour AS Date_Retour,
                DATEDIFF(CURDATE(), emprunts.date_retour) AS Jours_Retard
                FROM emprunts
                JOIN livres ON emprunts.id_livre = livres.id_livre
                JOIN members ON emprunts.id_membre = members.id_membre
                WHERE emprunts.date_retour < CURDATE() AND emprunts.date_retour IS NOT NULL";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <h2>Rapport des Retards</h2>
        <table>
            <thead>
                <tr>
                    <th>Membre</th>
                    <th>Livre</th>
                    <th>Date d'Emprunt</th>
                    <th>Date de Retour</th>
                    <th>Jours de Retard</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($rows as $row) { ?>
                    <tr>
                        <td><?php echo $row['Membre']; ?></td>
                        <td><?php echo $row['Livre']; ?></td>
                        <td><?php echo $row['Date_Emprunt']; ?></td>
                        <td><?php echo $row['Date_Retour']; ?></td>
                        <td><?php echo $row['Jours_Retard']; ?></td>
                        <td>
                        <form method="POST">
                                <input type="hidden" name="memberId" value="<?php echo $row['Membre_ID']; ?>">
                                <input type="hidden" name="bookTitle" value="<?php echo $row['Livre']; ?>">
                                <button type="submit" class="btn btn-warning">Retourner le livre</button>
                            </form>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>

    <?php
    if ($showAlert) {
        echo "<script type='text/javascript'>alert('Retourner le livre : " . $bookTitle . " pour le membre ID: " . $memberId . "');</script>";
    }
    ?>

</body>

</html>
