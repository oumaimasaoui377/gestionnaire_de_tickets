<?php
session_start();
include('config.php');
if(!isset($_SESSION['user_id'])) header('Location: login.php');

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM tickets WHERE id_t = ?");
$stmt->execute([$id]);
$ticket = $stmt->fetch();

if(isset($_POST['update_status'])){
    $new_status = $_POST['statut'];
    $stmt = $pdo->prepare("UPDATE tickets SET statut = ? WHERE id_t = ?");
    $stmt->execute([$new_status, $id]);
    header("Location: view_ticket.php?id=$id");
}
?>
<!DOCTYPE html>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<div class="w3-container w3-margin">
    <a href="admin_dashboard.php" class="w3-button w3-light-blue">< Retour</a>
    <div class="w3-card-4 w3-white w3-margin-top">
        <header class="w3-container w3-blue"><h1>Ticket #<?= $ticket['id_t'] ?></h1></header>
        <div class="w3-container">
            <p><strong>Objet :</strong> <?= $ticket['titre'] ?></p>
            <p><strong>Catégorie :</strong> <?= $ticket['categorie'] ?></p>
            <p><strong>Description :</strong><br><?= nl2br($ticket['description']) ?></p>
            <p><strong>Statut actuel :</strong> <?= $ticket['statut'] ?></p>
            
            <form method="POST" class="w3-padding-16">
                <select name="statut" class="w3-select w3-border">
                    <option value="ouvert" <?= $ticket['statut'] == 'ouvert' ? 'selected' : '' ?>>Ouvert</option>
                    <option value="en cours" <?= $ticket['statut'] == 'en cours' ? 'selected' : '' ?>>En cours</option>
                    <option value="fermé" <?= $ticket['statut'] == 'fermé' ? 'selected' : '' ?>>Fermé</option>
                </select>
                <button name="update_status" class="w3-button w3-green w3-margin-top">Mettre à jour</button>
            </form>
        </div>
    </div>
</div>