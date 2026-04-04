<?php include('auth_check.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Mon Support - L'Atelier des Jeux</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body class="w3-light-grey">

<nav class="w3-sidebar w3-bar-block w3-white w3-collapse w3-card" style="width:250px;">
  <div class="w3-container w3-blue w3-padding-16">
    <h4><b>Bonjour, <?php echo htmlspecialchars($_SESSION['nom']); ?></b></h4> 
  </div>
  <a href="user_ticket.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-plus"></i> Nouveau Ticket</a>
  
  <a href="gestion_tickets.php" class="w3-bar-item w3-button w3-padding w3-blue"><i class="fa fa-list"></i> Mes tickets</a>
  
  <a href="profil.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-user"></i> Mon Profil</a>
  <a href="logout.php" class="w3-bar-item w3-button w3-padding w3-text-red"><i class="fa fa-sign-out"></i> Déconnexion</a>
</nav>

<div class="w3-main" style="margin-left:250px">
    <header class="w3-container w3-padding-16">
        <h2>Créer une demande d'assistance</h2>
    </header>

    <div class="w3-container">
        <div class="w3-card-4 w3-white w3-padding" style="max-width:600px;">
            <form action="user_ticket.php" method="POST">
                <label>Objet du problème</label>
                <input class="w3-input w3-border" type="text" name="titre" required>
                
                <label>Catégorie</label>
                <select class="w3-select w3-border" name="categorie"> 
                    <option value="Logiciel">Jeux Vidéo / Logiciel</option>
                    <option value="Matériel">Jeux de plateau / Matériel</option>
                    <option value="Compte">Accès / Compte</option>
                </select>

                <label>Description détaillée</label>
                <textarea class="w3-input w3-border" name="description" rows="5"></textarea>

                <div class="w3-section">
                    <button class="w3-button w3-blue" name="envoyer">Envoyer le ticket</button>
                    <a href="index.php" class="w3-button w3-light-grey">Retour</a>
                </div>
            </form>
            <?php
            if(isset($_POST['envoyer'])){
                $sql = "INSERT INTO tickets (titre, description, categorie, id_auteur) VALUES (?, ?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$_POST['titre'], $_POST['description'], $_POST['categorie'], $_SESSION['user_id']]);
                echo "<p class='w3-text-green'>Ticket #".$pdo->lastInsertId()." envoyé !</p>";
            }
            ?>
        </div>
    </div>
</div>
</body>
</html>