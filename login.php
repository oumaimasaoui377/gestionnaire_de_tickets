<?php
include('auth_check.php');

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
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Admin - Dashboard</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1e293b; /* Bleu Nuit */
            --accent: #3b82f6;  /* Bleu Moderne */
            --bg-light: #f8fafc;
            --text-dark: #334155;
            --success: #10b981;
        }

        body { font-family: 'Inter', sans-serif; background-color: var(--bg-light); color: var(--text-dark); }
        
        /* Sidebar redesign */
        .w3-sidebar { 
            width: 280px; 
            background-color: var(--primary) !important; 
            color: #fff !important;
            border-right: 1px solid #e2e8f0;
        }
        .sidebar-header { background-color: rgba(255,255,255,0.05); padding: 32px 16px; text-align: center; }
        
        .w3-bar-item { 
            transition: 0.3s; 
            margin: 4px 12px; 
            border-radius: 8px; 
            width: auto !important;
        }
        .w3-bar-item:hover { background-color: rgba(255,255,255,0.1) !important; color: #fff !important; }
        .active-link { background-color: var(--accent) !important; color: white !important; }

        /* Cards and Stats */
        .card-custom { 
            border: none; 
            border-radius: 12px; 
            transition: transform 0.2s; 
            overflow: hidden;
        }
        .card-custom:hover { transform: translateY(-3px); box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); }
        
        .grad-blue { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; }
        .grad-dark { background: linear-gradient(135deg, #475569 0%, #1e293b 100%); color: white; }

        /* Progress Bars */
        .progress-container { background-color: #e2e8f0; height: 8px; border-radius: 10px; margin-top: 8px; }
        .progress-bar { height: 8px; border-radius: 10px; transition: width 0.5s ease-in-out; }

        .last-connexions li { border-bottom: 1px solid #f1f5f9; }
        .last-connexions li:last-child { border: none; }
        
        h5 { font-weight: 600; letter-spacing: -0.5px; }
    </style>
</head>
<body class="w3-light-grey">

<nav class="w3-sidebar w3-collapse w3-animate-left" id="mySidebar">
  <div class="sidebar-header">
    <h4 style="margin:0; font-weight:700; text-transform:uppercase; letter-spacing:1px;">Atelier des Jeux</h4>
  </div>
  <div class="w3-container w3-padding-24">
    <div style="font-size: 0.9em; opacity: 0.7;">Connecté en tant que :</div>
    <div style="font-weight: 600; font-size: 1.1em;"><?php echo htmlspecialchars($_SESSION['nom']); ?></div>
    <span class="w3-tag w3-round w3-small" style="background: var(--success); margin-top:8px;">Admin Système</span>
  </div>
  <div class="w3-bar-block" style="margin-top:20px;">
    <a href="admin_dashboard.php" class="w3-bar-item w3-button w3-padding active-link"><i class="fa fa-dashboard fa-fw"></i> Vue d'ensemble</a>
    <a href="admin_users.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-users fa-fw"></i> Gestion Comptes</a>
    <a href="log_view.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-history fa-fw"></i> Logs Sécurité</a>
    <div style="margin-top: 50px;">
        <a href="logout.php" class="w3-bar-item w3-button w3-padding w3-text-red"><i class="fa fa-sign-out fa-fw"></i> Déconnexion</a>
    </div>
  </div>
</nav>

<div class="w3-main" style="margin-left:280px;">
  
  <div class="w3-container" style="padding-top:32px">
    <header>
        <h3 style="font-weight:700; color: var(--primary)">Tableau de bord</h3>
        <p class="w3-text-grey">Statistiques en temps réel et gestion des accès.</p>
    </header>

    <div class="w3-row-padding w3-margin-bottom" style="margin: 0 -16px;">
        <div class="w3-col s12 m6">
            <a href="admin_users.php" style="text-decoration:none">
                <div class="w3-container grad-blue w3-padding-24 w3-card card-custom">
                    <div class="w3-left"><i class="fa fa-user-plus w3-xxlarge"></i></div>
                    <div class="w3-right text-right">
                        <h4 style="margin:0">Ajouter</h4>
                        <span style="opacity:0.8">Nouvel Utilisateur</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="w3-col s12 m6">
            <a href="log_view.php" style="text-decoration:none">
                <div class="w3-container grad-dark w3-padding-24 w3-card card-custom">
                    <div class="w3-left"><i class="fa fa-shield w3-xxlarge"></i></div>
                    <div class="w3-right text-right">
                        <h4 style="margin:0">Audit</h4>
                        <span style="opacity:0.8">Journal de sécurité</span>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="w3-panel">
        <div class="w3-white w3-card card-custom w3-padding-24">
            <h5 class="w3-container"><b>Répartition des rôles</b></h5>
            <div class="w3-row-padding">
                <div class="w3-col s12 m4">
                    <p style="margin-bottom:0">Administrateurs (<?php echo $nb_admin; ?>)</p>
                    <div class="progress-container">
                        <div class="progress-bar" style="width:<?php echo $p_admin; ?>%; background-color: var(--primary);"></div>
                    </div>
                </div>
                <div class="w3-col s12 m4">
                    <p style="margin-bottom:0">Techniciens (<?php echo $nb_tech; ?>)</p>
                    <div class="progress-container">
                        <div class="progress-bar" style="width:<?php echo $p_tech; ?>%; background-color: var(--accent);"></div>
                    </div>
                </div>
                <div class="w3-col s12 m4">
                    <p style="margin-bottom:0">Utilisateurs (<?php echo $nb_user; ?>)</p>
                    <div class="progress-container">
                        <div class="progress-bar" style="width:<?php echo $p_user; ?>%; background-color: #94a3b8;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="w3-panel">
        <div class="w3-card w3-white card-custom">
            <header class="w3-container w3-padding-16" style="border-bottom: 1px solid #f1f5f9">
                <h5 style="margin:0"><i class="fa fa-clock-o w3-text-blue"></i> Dernières connexions</h5>
            </header>
            <ul class="w3-ul last-connexions">
                <?php
                $stmt = $pdo->query("SELECT nom, role, derniere_connexion FROM utilisateurs ORDER BY derniere_connexion DESC LIMIT 5");
                while ($user = $stmt->fetch()) {
                    $heure = $user['derniere_connexion'] ? date('H:i', strtotime($user['derniere_connexion'])) : "--:--";
                    $role_color = ($user['role'] == 'admin') ? 'w3-indigo' : 'w3-light-grey';
                    echo "<li class='w3-padding-16'>
                            <div class='w3-left' style='width:40px; height:40px; background:#f1f5f9; border-radius:50%; display:flex; align-items:center; justify-content:center; margin-right:15px'>
                                <i class='fa fa-user w3-text-grey'></i>
                            </div>
                            <span class='w3-large' style='font-weight:600'>" . htmlspecialchars($user['nom']) . "</span>
                            <span class='w3-tag w3-round-large w3-small $role_color w3-margin-left'>" . $user['role'] . "</span>
                            <span class='w3-right w3-text-grey' style='padding-top:8px'>$heure</span>
                          </li>";
                }
                ?>
            </ul>
        </div>
    </div>

  </div>
</div>

<script>
// Logique sidebar simplifiée pour mobile
function w3_open() {
    document.getElementById("mySidebar").style.display = "block";
}
function w3_close() {
    document.getElementById("mySidebar").style.display = "none";
}
</script>

</body>
</html>