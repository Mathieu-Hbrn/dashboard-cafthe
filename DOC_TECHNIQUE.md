# Documentation Technique - Dashboard Cafthe

Cette documentation s'adresse aux développeurs et vise à expliciter le fonctionnement interne, les choix d'architecture, et les règles de conception du projet **Dashboard Cafthe**.

## 1. Architecture Générale

Le projet repose sur le motif de conception **MVC (Modèle-Vue-Contrôleur)** réalisé sous forme de framework "maison" en **PHP natif**. Ce choix d'architecture garantit une forte ségrégation des responsabilités :

- **Le Modèle (`app/Models`)** : Gère l'accès aux données (base de données MySQL), les opérations CRUD (Create, Read, Update, Delete) et la logique métier spécifique aux entités (ex : calcul de TVA dans `Product.php`).
- **La Vue (`views/`)** : S'occupe de l'interface graphique (fichiers `.php` contenant de l'HTML/CSS/JS). Les vues sont purement passives : elles n'interagissent pas avec la base de données directement mais s'appuient sur les données transmises par les contrôleurs.
- **Le Contrôleur (`app/Controllers`)** : Fait le pont entre les vues et les modèles. Il intercepte les requêtes de l'utilisateur, vérifie la sécurité, appelle les méthodes des modèles pour récupérer/modifier des données, et retourne la vue adéquate.

> [!NOTE]  
> Le projet n'utilise aucun ORM externe ni gros framework type Laravel ou Symfony, ce qui offre d'excellentes performances et une compréhension totale bas niveau.

---

## 2. Cycle de vie d'une requête (Routage)

Toutes les requêtes entrantes sont redirigées vers un point d'entrée unique par le `.htaccess` (Front Controller) : `public/index.php`.

### Déroulement (Dispatcher) :
1. **Initialisation** : Démarrage des sessions (`session_start()`), définition des constantes (`ROOT`, `BASE_URL`), et lancement de l'Autoloader.
2. **Connexion BDD** : Instanciation de la classe `\App\Core\Database` qui gère un Singleton PDO.
3. **Analyse de l'URL** : L'URL est récupérée (`$_SERVER['REQUEST_URI']`) et segmentée via `explode('/', ...)`.
   - Par exemple : `/products/edit/12` est décomposé en `url[0] = 'products'`, `url[1] = 'edit'`, `url[2] = '12'`.
4. **Instanciation du Contrôleur** : Le dispatcher crée le contrôleur correspondant (ex: `ProductController`).
5. **Appel de la méthode** : Si une condition matche (ex: `url[1] === 'edit'`), la méthode correspondante est appelée avec les paramètres adéquats (ex: `$controller->edit(12)`).

---

## 3. Gestion de la Base de Données

Les communications avec la base de données **MySQL** sont centralisées dans le composant `app/Core/Database.php`.

### Configuration et Sécurité (config.php)
Les identifiants de la base de données ne sont plus écrits en dur dans le code source. Ils sont stockés dans un fichier `config.php` à la racine du projet, qui est **exclu de Git** via `.gitignore`.
Un fichier `config.sample.php` est fourni comme modèle.
La classe détecte toujours l'environnement d'exécution via `$_SERVER['HTTP_HOST']` pour sélectionner automatiquement le jeu d'identifiants (local ou production) fourni dans le `config.php`.

### Motif "Singleton"
`Database::getConnection()` retourne l'unique instance de la classe PDO (Patron de conception Singleton). Ceci évite d'ouvrir de multiples connexions BDD par requête HTTP. Le PDO utilise le mode d'erreur `PDO::ERRMODE_EXCEPTION`.

---

## 4. Rôles et Structure des Modèles

Chaque table principale de la base de données possède son propre objet Modèle (ex: `Product`, `Order`, `Client`). 

Un Modèle typique est instancié avec l'objet PDO en paramètre dans son constructeur :
```php
class Product {
    private $db;
    public function __construct(PDO $db) {
        $this->db = $db;
    }
    // ... méthodes findAll(), findById(), create(), delete(), update()
}
```

> [!TIP]
> Toujours utiliser les requêtes préparées (`$this->db->prepare()`) pour se prémunir des injections SQL lors de la création (CRUD).

---

## 5. Rôles et Structure des Contrôleurs

Les contrôleurs orchestrent les fonctionnalités. Par défaut, le constructeur d'un contrôleur de zone d'administration (comme `ProductController`) vérifiera si l'utilisateur est authentifié.

### Exigences du Contrôleur
- **Sécurité** : Si `$_SESSION['user_id']` n'existe pas, redirection vers `auth/login`.
- **Invocations** : Créer l'instance du ou des Modèles nécessaires.
- **Règles Routières** : Définir des méthodes comme `list()`, `add()`, `edit($id)`, `delete($id)`. 
- **Retour de Vue** : Injecter les requêtes dans des variables puis charger le template `views/...` avec `require_once`.

---

## 6. Sécurité Implémentée

### Authentification
Gérée par l'`AuthController` et s'appuyant sur les sessions natives PHP (`$_SESSION['user_id']`). Les pages sécurisées bloquent l'accès au constructeur de chaque contrôleur concerné.

### Prévention des Failles
- **Injections SQL** : Utilisation exclusive du module PDO avec requêtes préparées dans le répertoire `/Models` (aucune donnée utilisateur n'entre directement dans les requêtes de `query()`).
- **CSRF (Cross-Site Request Forgery)** : Implémentation d'un validateur via le composant `\App\Core\CSRF::validate()`. Sur les méthodes `POST`, si le token de sécurité intégré au formulaire ne correspond pas à la session active, l'opération est avortée.
- **XSS (Cross-Site Scripting)** : Toutes les données affichées côté client via les vues doivent être affichées en filtrant les caractères spéciaux (le cas échéant via `htmlspecialchars`).

---

## 7. Directives pour l'ajout de nouvelles fonctionnalités

Si vous souhaitez créer, par exemple, un module de gestion des "Fournisseurs" :

1. **Base de données** : Créez la table `fournisseurs`.
2. **Modèle** : Créez `app/Models/Fournisseur.php` contenant le CRUD PDO.
3. **Contrôleur** : Créez `app/Controllers/FournisseurController.php` contenant les méthodes `list()`, `add()`, etc...
4. **Dispatcheur** : Modifiez `public/index.php` en rajoutant une clause `elseif ($url[0] === 'fournisseurs')` pour relier l'url à votre nouveau contrôleur.
5. **Vues** : Créez le dossier `views/fournisseurs/` avec les fichiers `.php` correspondants.
