<?php
session_start();
include('config.php');
if(!isset($_SESSION['user_id'])) exit();

$id = $_GET['id'];
$statut = $_GET['s'];

$stmt = $pdo->prepare("UPDATE tickets SET statut = ? WHERE id_t = ?");
$stmt->execute([$statut, $id]);

// Mise en place d'un log simple [cite: 43]
$log = $pdo->prepare("INSERT INTO logs (action, id_u) VALUES (?, ?)");
$log->execute(["Changement statut ticket #$id vers $statut", $_SESSION['user_id']]);

header('Location: admin_dashboard.php');
?>