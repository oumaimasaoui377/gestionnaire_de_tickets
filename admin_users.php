<?php
session_start();
include('config.php');
// Sécurité : Seul l'admin peut accéder [cite: 16, 42]
if($_SESSION['role'] !== 'admin') { header('Location: admin_dashboard.php'); exit(); }

if(isset($_POST['create_user'])){
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $pass = md5($_POST['password']); // Chiffrement MD5 [cite: 26, 44]
    $role = $_POST['role'];

    $stmt = $pdo->prepare("INSERT INTO utilisateurs (nom, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nom, $email, $pass, $role]);
    echo "<div class='w3-panel w3-green'>Utilisateur créé !</div>";
}

$users = $pdo->query("SELECT id_u, nom, email, role FROM utilisateurs")->fetchAll();
?>
<!DOCTYPE html>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<body class="w3-light-grey">
    <div class="w3-bar w3-black">
        <a href="admin_dashboard.php" class="w3-bar-item w3-button">Tickets</a>
        <a href="logout.php" class="w3-bar-item w3-button w3-right">Déconnexion</a>
    </div>

    <div class="w3-container w3-margin">
        <h3>Créer un utilisateur (Technicien/Admin)</h3>
        <form method="POST" class="w3-container w3-white w3-card-4 w3-padding">
            <input class="w3-input" type="text" name="nom" placeholder="Nom" required>
            <input class="w3-input" type="email" name="email" placeholder="Email" required>
            <input class="w3-input" type="password" name="password" placeholder="Mot de passe" required>
            <select class="w3-select" name="role">
                <option value="utilisateur">Utilisateur</option>
                <option value="technicien">Technicien</option>
                <option value="admin">Administrateur</option>
            </select>
            <button class="w3-button w3-blue w3-margin-top" name="create_user">Ajouter</button>
        </form>

        <h3>Liste des comptes</h3>
        <table class="w3-table-all">
            <tr><th>Nom</th><th>Email</th><th>Rôle</th></tr>
            <?php foreach($users as $u): ?>
            <tr><td><?= $u['nom'] ?></td><td><?= $u['email'] ?></td><td><?= $u['role'] ?></td></tr>
            <?php endforeach; ?>
        </table>
        <div class="w3-container w3-padding-16">
    <a href="admin_dashboard.php" class="w3-button w3-light-grey w3-round">
        <i class="fa fa-arrow-left"></i> Retour au Dashboard
    </a>
</div>
    </div>
</body>