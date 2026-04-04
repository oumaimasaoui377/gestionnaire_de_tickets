<?php include('auth_check.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Mes Tickets - L'Atelier des Jeux</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body class="w3-light-grey">

<div class="w3-main" style="margin-left:250px">
    <header class="w3-container w3-padding-16">
        <h2>Historique de mes demandes</h2>
    </header>

    <div class="w3-container">
        <table class="w3-table w3-striped w3-white w3-card-4">
            <thead>
                <tr class="w3-blue">
                    <th>ID</th>
                    <th>Objet</th>
                    <th>Statut</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // On filtre par l'ID de l'utilisateur connecté
                $stmt = $pdo->prepare("SELECT * FROM tickets WHERE id_auteur = ? ORDER BY date_creation DESC");
                $stmt->execute([$_SESSION['user_id']]);
                
                while($t = $stmt->fetch()) {
                    $color = ($t['statut'] == 'ouvert') ? 'w3-red' : (($t['statut'] == 'en cours') ? 'w3-orange' : 'w3-green');
                    echo "<tr>
                            <td>#{$t['id_t']}</td>
                            <td>" . htmlspecialchars($t['titre']) . "</td>
                            <td><span class='w3-tag $color w3-round'>{$t['statut']}</span></td>
                            <td>{$t['date_creation']}</td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
        <div class="w3-padding-16">
            <a href="user_ticket.php" class="w3-button w3-blue w3-round">Créer un nouveau ticket</a>
        </div>
    </div>
    <a href="admin_dashboard.php" class="w3-button w3-light-grey w3-round">
        <i class="fa fa-arrow-left"></i> Retour au Dashboard
</div>
</body>
</html>