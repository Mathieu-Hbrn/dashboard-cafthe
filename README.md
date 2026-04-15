# Dashboard Cafthe

## Description
Dashboard Cafthe est une application web de gestion construite selon l'architecture logicielle MVC (Modèle-Vue-Contrôleur) en PHP natif (sans framework externe). Ce projet permet de gérer facilement et d'administrer différents aspects liés au commerce (produits, commandes, clients, vendeurs, etc.) via une interface centralisée et sécurisée.

## Fonctionnalités Principales
- **Tableau de Bord (Dashboard)** : Vue d'ensemble, statistiques et résumé des données clés.
- **Gestion des Produits** : Ajout, modification, suppression et liste des produits.
- **Gestion des Commandes** : Suivi des commandes, mise à jour des statuts et visualisation détaillée.
- **Gestion des Clients** : Création, édition et suivi des clients.
- **Gestion des Vendeurs** : Ajout, modification et suppression de collaborateurs/vendeurs.
- **Profil Utilisateur** : Gestion des informations personnelles.
- **Authentification Sécurisée** : Système de connexion et déconnexion avec restriction d'accès aux pages.

## Architecture et Technologies Utilisées
- **Langage Backend** : PHP (Orienté Objet)
- **Architecture** : MVC Customisé (Modèle - Vue - Contrôleur) avec un Routeur (Dispatcher) intégré et géré depuis `public/index.php`.
- **Base de données** : MySQL, avec une connexion sécurisée via l'extension **PDO** (`App\Core\Database`).
- **Autoloading** : Chargement automatique des classes via `spl_autoload_register`.
- **Environnements** : Détection automatique des environnements de développement (Localhost/XAMPP) et de production.

## Principale Structure de Répertoires
```text
dashboard-cafthe/
├── app/
│   ├── Controllers/  # Logique de contrôle, requêtes des modèles et passage aux vues
│   ├── Core/         # Classes centrales de l'application (ex: connexion PDO Database.php)
│   └── Models/       # Communications avec la base de données
├── public/
│   ├── .htaccess     # Réécriture d'URL pour pointer vers index.php
│   ├── assets/       # Ressources statiques (images, etc)
│   ├── css/          # Feuilles de style (design)
│   └── index.php     # Point d'entrée unique du système (Front Controller / Routeur)
├── views/            # Fichiers contenant le code de l'interface utilisateur (HTML/PHP)
└── README.md         # Documentation du projet
```

## Installation en Local (XAMPP / WAMP)

1. **Placer le projet** : 
   Placez le dossier `dashboard-cafthe` dans le répertoire d'exécution de votre serveur local (ex: `C:\xampp\htdocs\`).
   
2. **Configuration de la Base de données** :
   Dupliquez le fichier `config.sample.php` à la racine du projet et renommez-le en `config.php`.
   Modifiez ensuite `config.php` pour y insérer vos identifiants de base de données :
   - Hôte : `localhost`
   - Base de données : `BASE_CAFTHE`
   - Utilisateur : `root` (ou votre utilisateur)
   - Mot de passe : *(vide en local généralement)*
   
   *Assurez-vous que cette base de données existe sur votre serveur SQL local et que vos différentes tables soient créées pour que les modèles fonctionnent correctement.*
   
3. **Accès à l'application** :
   Accédez au projet depuis votre navigateur via l'URL : 
   [http://localhost/dashboard-cafthe/public/](http://localhost/dashboard-cafthe/public/)

## Routage / URLs
Toutes les requêtes passent par `public/index.php`. Les URLs sont découpées et analysées pour appeler le bon Contrôleur et la bonne Méthode.
Exemple : 
L'URL `http://localhost/dashboard-cafthe/public/products` va automatiquement instancier `App\Controllers\ProductController` et appeler la méthode de listage.

## Déploiement en Production
Le composant de base de données bascule automatiquement sur les identifiants de production renseignés dans votre fichier `config.php` dès lors que l'application détecte qu'elle n'est plus hébergée sur `localhost`. 
*Note de sécurité importante : Le fichier `config.php` est ignoré par `.gitignore` pour garantir qu'il ne sera jamais publié sur votre dépôt Git.*
