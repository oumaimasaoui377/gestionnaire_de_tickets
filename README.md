# Systeme de Gestion de Tickets - L'Atelier des Jeux

Ce projet est une application web de gestion de tickets d'assistance technique, permettant aux utilisateurs de soumettre des problemes et aux techniciens de les resoudre.

## Fonctionnalites
- Authentification Multi-roles : Administrateur, Technicien, Utilisateur.
- Gestion des Tickets : Creation, suivi de statut (Ouvert, En cours, Ferme).
- Tableau de Bord Admin : Statistiques en temps reel sur les utilisateurs et les tickets.
- Securite : Protection des routes et hachage des mots de passe.

## Apercu du Projet

### 1. Interface de Connexion
![Login](login.png)

### 2. Dashboard Administrateur
![Admin Dashboard](dashboard.png)

### 3. Structure de la Base de Donnees
![Database](database.png)

## Technologies Utilisees
- Backend : PHP (PDO)
- Frontend : HTML5, CSS3 (W3.CSS / Bootstrap)
- Base de donnees : MySQL (XAMPP / PHPMyAdmin)

## Identifiants de Test
| Role | Identifiant | Mot de passe |
| :--- | :--- | :--- |
| Administrateur | admin | admin123 |
| Technicien | technicien | tech123 |
| Utilisateur | mdupont | password |

## Installation Locale
1. Cloner le projet : git clone https://github.com/oumaimasaoui377/gestionnaire_de_tickets.git
2. Importer le fichier .sql dans PHPMyAdmin.
3. Configurer config.php avec vos acces locaux.
4. Lancer par localhost.
