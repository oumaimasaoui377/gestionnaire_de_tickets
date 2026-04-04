<?php
include('config.php');

$show_modal = false;
$generated_username = "";

if(isset($_POST['reg'])){
    $nom = $_POST['nom_famille'];
    $prenom = $_POST['prenom'];
    
    // Génération automatique (Initiale prénom + Nom)
    $generated_username = strtolower(substr($prenom, 0, 1) . $nom);
    $pass = md5($_POST['password']);
    
    $stmt = $pdo->prepare("INSERT INTO utilisateurs (nom, email, password, role) VALUES (?, ?, ?, 'utilisateur')");
    
    if($stmt->execute([$generated_username, $_POST['email'], $pass])) {
        $show_modal = true; // On déclenche l'affichage du message de succès
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Inscription - L'Atelier des Jeux</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>body, h1, h2 { font-family: "Raleway", sans-serif; }</style>
</head>
<body class="w3-dark-grey">

    <div class="w3-display-middle" style="width:100%; max-width:500px; padding:16px;">
        <div class="w3-card-4 w3-white w3-round-large">
            <header class="w3-container w3-blue w3-round-large w3-center">
                <h3>Créer un compte</h3>
            </header>
            
            <form method="POST" class="w3-container w3-padding-24">
                <div class="w3-row-padding">
                    <div class="w3-half">
                        <label>Prénom</label>
                        <input class="w3-input w3-border w3-round" type="text" name="prenom" placeholder="Alice" required>
                    </div>
                    <div class="w3-half">
                        <label>Nom</label>
                        <input class="w3-input w3-border w3-round" type="text" name="nom_famille" placeholder="Martin" required>
                    </div>
                </div>

                <div class="w3-container">
                    <label>Email</label>
                    <input class="w3-input w3-border w3-round" type="email" name="email" required>
                    
                    <label>Mot de passe</label>
                    <input class="w3-input w3-border w3-round" type="password" name="password" required>
                    
                    <button class="w3-button w3-block w3-blue w3-section w3-round" name="reg">S'inscrire</button>
                    <a href="login.php" class="w3-button w3-block w3-light-grey w3-round">Retour à la connexion</a>
                </div>
            </form>
        </div>
    </div>

    <?php if($show_modal): ?>
    <div id="successModal" class="w3-modal" style="display:block">
        <div class="w3-modal-content w3-card-4 w3-animate-zoom w3-round-large" style="max-width:400px">
            <header class="w3-container w3-green w3-center w3-round-large">
                <h3><i class="fa fa-check-circle"></i> Inscription réussie !</h3>
            </header>
            <div class="w3-container w3-padding-24 w3-center">
                <p>Bienvenue à L'Atelier des Jeux.</p>
                <p>Votre nom d'utilisateur pour vous connecter est :</p>
                <h4 class="w3-tag w3-light-grey w3-border w3-xlarge"><b><?php echo $generated_username; ?></b></h4>
                <div class="w3-margin-top">
                    <a href="login.php" class="w3-button w3-blue w3-round w3-large" style="width:100px">OK</a>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

</body>
</html>