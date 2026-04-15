<?php
// Exemple de fichier de configuration.
// Renommez ce fichier en "config.php" et indiquez vos informations de connexion à la base de données.
return [
    'local' => [
        'host' => 'localhost',
        'db'   => 'VOTRE_BDD_LOCALE',
        'user' => 'root',
        'pass' => ''
    ],
    'production' => [
        'host' => 'localhost',
        'db'   => 'VOTRE_BDD_PROD',
        'user' => 'VOTRE_UTILISATEUR',
        'pass' => 'VOTRE_MOT_DE_PASSE'
    ]
];
