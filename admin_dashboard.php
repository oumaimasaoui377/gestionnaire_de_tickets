<?php

include('auth_check.php');

// Sécurité : Seul l'admin accède à cette page
if ($_SESSION['role'] !== 'admin') {
    header('Location: tech_dashboard.php');
    exit();
}

// Calcul des Statistiques
$nb_admin = $pdo->query("SELECT COUNT(*) FROM utilisateurs WHERE role='admin'")->fetchColumn();
$nb_tech  = $pdo->query("SELECT COUNT(*) FROM utilisateurs WHERE role='technicien'")->fetchColumn();
$nb_user  = $pdo->query("SELECT COUNT(*) FROM utilisateurs WHERE role='utilisateur'")->fetchColumn();

$total_users = $nb_admin + $nb_tech + $nb_user;
$total_div = ($total_users == 0) ? 1 : $total_users;

$p_admin = ($nb_admin / $total_div) * 100;
$p_tech  = ($nb_tech / $total_div) * 100;
$p_user  = ($nb_user / $total_div) * 100;
?>
<nav class="navbar">
    <div class="logo">Ticket Manager</div>
    <button id="theme-toggle" class="theme-switch">
        <span id="theme-icon">🌙</span>
    </button>
</nav>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Admin - Dashboard</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body { font-family: "Raleway", sans-serif; }
        .w3-sidebar { z-index: 3; width: 300px; height: 100%; position: fixed; }
    </style>
</head>
<body class="w3-light-grey">

<nav class="w3-sidebar w3-collapse w3-white w3-card w3-animate-left" style="z-index:5; width:300px; top:0;" id="mySidebar">
  <div class="w3-container w3-padding-16 w3-blue">
    <h5><b>L'Atelier des Jeux</b></h5>
  </div>
  <div class="w3-container w3-padding-16">
    <h5>Bienvenue, <b><?php echo htmlspecialchars($_SESSION['nom']); ?></b></h5>
    <span class="w3-tag w3-blue w3-round">Administrateur</span>
  </div>
  <hr>
  <div class="w3-bar-block">
    <a href="#" onclick="w3_close()" class="w3-bar-item w3-button w3-padding-16 w3-hide-large w3-dark-grey"><i class="fa fa-remove"></i> Fermer</a>
    <a href="admin_users.php" class="w3-bar-item w3-button w3-padding w3-blue"><i class="fa fa-users fa-fw"></i> Gestion Comptes</a>
    <a href="log_view.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-history fa-fw"></i> Logs Connexions</a>
    <a href="logout.php" class="w3-bar-item w3-button w3-padding w3-text-red"><i class="fa fa-sign-out fa-fw"></i> Déconnexion</a>
  </div>
</nav>

<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" id="myOverlay"></div>

<div class="w3-bar w3-top w3-black w3-large w3-hide-large" style="z-index:4">
  <button class="w3-bar-item w3-button w3-hover-none w3-hover-text-light-grey" onclick="w3_open();"><i class="fa fa-bars"></i> Menu</button>
  <span class="w3-bar-item w3-right">Admin</span>
</div>

<div class="w3-main" style="margin-left:300px;">
  <div class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-dashboard"></i> Administration du Système</b></h5>
    </header>

    <div class="w3-row-padding w3-margin-bottom">
        <div class="w3-col s12 m6">
            <a href="admin_users.php" style="text-decoration:none">
                <div class="w3-container w3-blue w3-padding-16 w3-card w3-round w3-hover-opacity">
                    <div class="w3-left"><i class="fa fa-user-plus w3-xxlarge"></i></div>
                    
                    <div class="w3-clear"></div>
                    <h4>Créer un compte</h4>
                </div>
            </a>
        </div>
        <div class="w3-col s12 m6">
            <a href="log_view.php" style="text-decoration:none">
                <div class="w3-container w3-dark-grey w3-padding-16 w3-card w3-round w3-hover-opacity">
                    <div class="w3-left"><i class="fa fa-eye w3-xxlarge"></i></div>
                    
                    <div class="w3-clear"></div>
                    <h4>Voir les connexions</h4>
                </div>
            </a>
        </div>
    </div>

    <div class="w3-container">
        <div class="w3-white w3-card w3-round w3-padding-16">
            <h5 class="w3-padding-small"><b><i class="fa fa-users"></i> Répartition des rôles</b></h5>
            <div class="w3-row-padding">
                <div class="w3-col s12 m4">
                    <p>Administrateurs (<?php echo $nb_admin; ?>)</p>
                    <div class="w3-grey w3-round">
                        <div class="w3-container w3-round w3-indigo" style="width:<?php echo $p_admin; ?>%">&nbsp;</div>
                    </div>
                </div>
                <div class="w3-col s12 m4">
                    <p>Techniciens (<?php echo $nb_tech; ?>)</p>
                    <div class="w3-grey w3-round">
                        <div class="w3-container w3-round w3-blue" style="width:<?php echo $p_tech; ?>%">&nbsp;</div>
                    </div>
                </div>
                <div class="w3-col s12 m4">
                    <p>Utilisateurs (<?php echo $nb_user; ?>)</p>
                    <div class="w3-grey w3-round">
                        <div class="w3-container w3-round w3-light-blue" style="width:<?php echo $p_user; ?>%">&nbsp;</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="w3-panel">
        <div class="w3-card w3-white w3-round">
            <header class="w3-container w3-light-grey w3-round">
                <h5><i class="fa fa-clock-o"></i> Dernières connexions</h5>
            </header>
            <ul class="w3-ul w3-hoverable">
                <?php
                $stmt = $pdo->query("SELECT nom, role, derniere_connexion FROM utilisateurs ORDER BY derniere_connexion DESC LIMIT 5");
                while ($user = $stmt->fetch()) {
                    $heure = $user['derniere_connexion'] ? date('H:i', strtotime($user['derniere_connexion'])) : "--:--";
                    echo "<li class='w3-padding-16'>
                            <span class='w3-large'>" . htmlspecialchars($user['nom']) . "</span>
                            <span class='w3-tag w3-small w3-light-grey w3-margin-left'>" . $user['role'] . "</span>
                            <span class='w3-right w3-text-grey'>$heure</span>
                          </li>";
                }
                ?>
            </ul>
        </div>
    </div>

</div> <script>
var mySidebar = document.getElementById("mySidebar");
var overlayBg = document.getElementById("myOverlay");

function w3_open() {
    if (mySidebar.style.display === 'block') {
        mySidebar.style.display = 'none';
        overlayBg.style.display = "none";
    } else {
        mySidebar.style.display = 'block';
        overlayBg.style.display = "block";
    }
}
function w3_close() {
    mySidebar.style.display = "none";
    overlayBg.style.display = "none";
}
</script>

</body>
</html>