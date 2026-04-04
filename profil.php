<?php include('auth_check.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Paramètres - L'Atelier des Jeux</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body class="w3-light-grey">

<nav class="w3-sidebar w3-bar-block w3-white w3-collapse w3-card" style="width:250px;">
  <div class="w3-container w3-blue w3-padding-16">
    <h4><b>Bonjour, <?php echo htmlspecialchars($_SESSION['nom']); ?></b></h4>
  </div>
  
  <a href="profil.php" class="w3-bar-item w3-button w3-padding w3-blue"><i class="fa fa-cog"></i> Paramètres du compte</a>
  <a href="logout.php" class="w3-bar-item w3-button w3-padding w3-text-red"><i class="fa fa-sign-out"></i> Déconnexion</a>
</nav>

<div class="w3-main" style="margin-left:250px">
    <header class="w3-container w3-padding-16">
        <h2>Gestion de votre compte</h2>
    </header>

    <div class="w3-container">
        <div class="w3-card-4 w3-white w3-margin-bottom" style="max-width:600px;">
            <header class="w3-container w3-light-blue">
                <h4>Modifier le mot de passe</h4>
            </header>
            <form class="w3-container w3-padding" method="POST">
                <label>Nouveau mot de passe</label>
                <input class="w3-input w3-border" type="password" name="new_pass" required>
                <button class="w3-button w3-blue w3-margin-top" name="update">Enregistrer</button>
            </form>
        </div>

        <div class="w3-card-4 w3-white" style="max-width:600px;">
            <header class="w3-container w3-red">
                <h4>Zone de danger</h4>
            </header>
            <div class="w3-container w3-padding">
                <p>La suppression de votre compte est définitive. Tous vos tickets resteront anonymisés.</p>
                <form method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.');">
                    <button class="w3-button w3-red" name="delete_account">Supprimer mon compte</button>
                </form>
            </div>
        </div> <br>
<a href="admin_dashboard.php" class="w3-button w3-light-grey w3-round">
        <i class="fa fa-arrow-left"></i> Retour au Dashboard
        <?php
        // Traitement PHP
        if(isset($_POST['update'])){
            $pass = md5($_POST['new_pass']); // Hachage pour la sécurité [cite: 26, 44]
            $stmt = $pdo->prepare("UPDATE utilisateurs SET password = ? WHERE id_u = ?");
            if($stmt->execute([$pass, $_SESSION['user_id']])) {
                echo "<p class='w3-text-green w3-margin'>Mot de passe mis à jour !</p>";
            }
        }

        if(isset($_POST['delete_account'])){
            // Suppression du compte 
            $stmt = $pdo->prepare("DELETE FROM utilisateurs WHERE id_u = ?");
            if($stmt->execute([$_SESSION['user_id']])) {
                session_destroy();
                header("Location: login.php?msg=compte_supprime");
                exit();
            }
        }
        ?>
    </div>
</div>
</body>
</html>