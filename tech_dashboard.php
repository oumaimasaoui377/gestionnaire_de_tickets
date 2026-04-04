<?php
include('auth_check.php');

// 1. Sécurité : Accès restreint au staff
if ($_SESSION['role'] == 'utilisateur') {
    header('Location: user_ticket.php');
    exit();
}

// 2. Calcul des Statistiques
$ouvert = $pdo->query("SELECT COUNT(*) FROM tickets WHERE statut='ouvert'")->fetchColumn();
$en_cours = $pdo->query("SELECT COUNT(*) FROM tickets WHERE statut='en cours'")->fetchColumn();
$ferme = $pdo->query("SELECT COUNT(*) FROM tickets WHERE statut='fermé'")->fetchColumn();

$total = $ouvert + $en_cours + $ferme;
$total_div = ($total == 0) ? 1 : $total;

$p_ouvert = ($ouvert / $total_div) * 100;
$p_encours = ($en_cours / $total_div) * 100;
$p_ferme = ($ferme / $total_div) * 100;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Technicien - Support</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body, h1, h2, h3, h4, h5 { font-family: "Raleway", sans-serif; }
        /* Force la hauteur totale et le placement */
        .w3-sidebar { height: 100% !important; position: fixed; bottom: 0; }
    </style>
</head>
<body class="w3-light-grey">

<nav class="w3-sidebar w3-collapse w3-white w3-card w3-animate-left" style="z-index:5; width:300px; top:0;" id="mySidebar">
  <div class="w3-container w3-padding-16 w3-blue w3-text-white">
    <h5><b>L'Atelier des Jeux</b></h5>
  </div>
  
  <div class="w3-container w3-padding-16">
    <h5>Bienvenue, <b><?php echo htmlspecialchars($_SESSION['nom']); ?></b></h5>
    <span class="w3-tag w3-orange w3-text-white w3-round">Technicien</span>
  </div>
  <hr>
  <div class="w3-bar-block">
    <a href="#" onclick="w3_close()" class="w3-bar-item w3-button w3-padding-16 w3-hide-large w3-dark-grey"><i class="fa fa-remove fa-fw"></i> Fermer</a>
    
    <a href="tech_dashboard.php" class="w3-bar-item w3-button w3-padding w3-blue"><i class="fa fa-ticket fa-fw"></i> Tous les Tickets</a>
    <a href="profil.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-cog fa-fw"></i> Paramètres</a>
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
    <h5><b><i class="fa fa-dashboard"></i> Gestion des tickets</b></h5>
  </header>

  <div class="w3-container">
    <div class="w3-row-padding w3-margin-bottom w3-white w3-card w3-round w3-padding-16">
        <div class="w3-col s12 m4">
            <p>Ouverts (<?php echo $ouvert; ?>)</p>
            <div class="w3-grey w3-round"><div class="w3-container w3-round <?php echo ($ouvert > 0 ? 'w3-red' : ''); ?>" style="width:<?php echo $p_ouvert; ?>%">&nbsp;</div></div>
        </div>
        <div class="w3-col s12 m4">
            <p>En cours (<?php echo $en_cours; ?>)</p>
            <div class="w3-grey w3-round"><div class="w3-container w3-round <?php echo ($en_cours > 0 ? 'w3-orange' : ''); ?>" style="width:<?php echo $p_encours; ?>%">&nbsp;</div></div>
        </div>
        <div class="w3-col s12 m4">
            <p>Fermés (<?php echo $ferme; ?>)</p>
            <div class="w3-grey w3-round"><div class="w3-container w3-round <?php echo ($ferme > 0 ? 'w3-green' : ''); ?>" style="width:<?php echo $p_ferme; ?>%">&nbsp;</div></div>
        </div>
    </div>

    <div class="w3-container w3-white w3-card w3-round w3-padding-16">
        <h5 class="w3-bottombar w3-border-blue"><b><i class="fa fa-list"></i> Tickets à traiter</b></h5>
        <div class="w3-responsive">
            <table class="w3-table w3-striped w3-hoverable">
              <thead>
                <tr class="w3-blue">
                  <th>ID</th><th>Objet</th><th>Catégorie</th><th>Statut</th><th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $stmt = $pdo->query("SELECT * FROM tickets ORDER BY date_creation DESC");
                while($t = $stmt->fetch()) {
                    $color = ($t['statut'] == 'ouvert') ? 'w3-red' : (($t['statut'] == 'en cours') ? 'w3-orange' : 'w3-green');
                    echo "<tr>
                            <td>#{$t['id_t']}</td>
                            <td>" . htmlspecialchars($t['titre']) . "</td>
                            <td>" . htmlspecialchars($t['categorie']) . "</td>
                            <td><span class='w3-tag $color w3-round'>{$t['statut']}</span></td>
                            <td><a href='view_ticket.php?id={$t['id_t']}' class='w3-button w3-small w3-black w3-round'>Traiter</a></td>
                          </tr>";
                }
                ?>
              </tbody>
            </table>
        </div>
    </div>
  </div>
</div>

<script>
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