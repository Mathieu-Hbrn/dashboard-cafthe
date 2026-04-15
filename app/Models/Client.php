<?php
namespace App\Models;
use PDO;

class Client
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    // On trie par nom_prenom_client car nom_client n'existe pas
    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM client ORDER BY nom_prenom_client ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // On cherche dans les colonnes Mail_client et nom_prenom_client
    public function searchClients($term)
    {
        $searchTerm = "%" . $term . "%";
        $sql = "SELECT * FROM client 
                WHERE nom_prenom_client LIKE :term 
                OR Mail_client LIKE :term 
                OR Telephone_client LIKE :term";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['term' => $searchTerm]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Récupérer un client par son ID
    public function getClientById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM client WHERE id_client = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Mettre à jour les infos du client
    public function updateClient($id, $data)
    {
        $sql = "UPDATE client SET 
            nom_prenom_client = :nom, 
            Mail_client = :mail, 
            Telephone_client = :tel, 
            adresse_client = :adresse 
            WHERE id_client = :id";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'nom' => $data['nom_prenom_client'],
            'mail' => $data['Mail_client'],
            'tel' => $data['Telephone_client'],
            'adresse' => $data['adresse_client'],
            'id' => $id
        ]);
    }
    // Ajouter un nouveau client
    public function createClient($data)
    {
        $sql = "INSERT INTO client (nom_prenom_client, Telephone_client, Mail_client, mdp_client, adresse_client, Date_inscription_client) 
            VALUES (:nom, :tel, :mail, :mdp, :adresse, NOW())";

        $stmt = $this->db->prepare($sql);

        // Hachage du mot de passe
        $hashedPassword = password_hash($data['mdp_client'], PASSWORD_DEFAULT);
        $hashedPasswordCompat = str_replace('$2y$', '$2a$', $hashedPassword);


        return $stmt->execute([
            'nom' => $data['nom_prenom_client'],
            'tel' => $data['Telephone_client'],
            'mail' => $data['Mail_client'],
            'mdp' => $hashedPasswordCompat,
            'adresse' => $data['adresse_client']
        ]);
    }
}