<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Vérification de l'inactivité (1 mois)
$stmt = $pdo->prepare("SELECT derniere_connexion, role FROM utilisateurs WHERE id_u = ?");
$stmt->execute([$_SESSION['user_id']]);
$u = $stmt->fetch();

$now = new DateTime();
$last_co = new DateTime($u['derniere_connexion']);
$interval = $last_co->diff($now);

if ($interval->m >= 1 || $interval->y >= 1) { // Si 1 mois ou plus
    $update = $pdo->prepare("UPDATE utilisateurs SET role = 'inactif' WHERE id_u = ?");
    $update->execute([$_SESSION['user_id']]);
    session_destroy();
    header('Location: login.php?err=inactif');
    exit();
}
?>