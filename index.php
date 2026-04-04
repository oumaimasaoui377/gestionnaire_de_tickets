<?php
session_start();
include('config.php');

// Si pas connecté, on envoie vers la page de login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Si connecté, on redirige selon le rôle
if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'technicien') {
    header('Location: admin_dashboard.php'); // Interface complète 
} else {
    header('Location: user_ticket.php'); // Formulaire de demande 
}
exit();
?>