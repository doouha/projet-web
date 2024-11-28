<?php
include 'C:\xampp\htdocs\projet web\config.php';
class ReclamationC {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function readReclamations() {
        try {
            $sql = "SELECT * FROM reclamation_q";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erreur lors de la récupération des réclamations: " . $e->getMessage());
        }
    }

    public function getLastId() {
        try {
            $sql = "SELECT MAX(id_reclamation) AS last_id FROM reclamation_q";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result['last_id'] !== null) {
                return $result['last_id'] + 1;
            } else {
                return 1; 
            }
        } catch (PDOException $e) {
            return 'Erreur : ' . $e->getMessage();
        }
    }

    public function addReclamation($id_client, $contenue) {
        try {
            $id_reclamation = $this->getLastId(); 
            $date = date('Y-m-d H:i:s'); 
            $sql = "INSERT INTO reclamation_q (id_reclamation, id_client, contenue, date)
                    VALUES (:id_reclamation, :id_client, :contenue, :date)";
            $stmt = $this->db->prepare($sql);
    
            if ($stmt->execute([
                ':id_reclamation' => $id_reclamation,
                ':id_client' => $id_client,
                ':contenue' => $contenue,
                ':date' => $date
            ])) {

                $historique = $this->historiqueReclamations($id_client);
                return [
                    "message" => "Réclamation ajoutée avec succès !",
                    "historique" => $historique
                ];
            } else {
                return [
                    "message" => "Erreur lors de l'exécution de la requête.",
                    "historique" => []
                ];
            }
        } catch (PDOException $e) {
            return [
                "message" => 'Erreur : ' . $e->getMessage(),
                "historique" => []
            ];
        }
    }
    

    public function updateReclamation($id_reclamation, $id_client, $contenue, $date) {
        try {
            $sql = "UPDATE reclamation_q SET
                    date = :date,
                    contenue = :contenue,
                    id_client = :id_client
                    WHERE id_reclamation = :id_reclamation";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':date' => $date,
                ':contenue' => $contenue,
                ':id_client' => $id_client,
                ':id_reclamation' => $id_reclamation
            ]);
            return "Réclamation mise à jour avec succès !";
        } catch (PDOException $e) {
            return 'Erreur : ' . $e->getMessage();
        }
    }


    public function deleteReclamation($id_reclamation) {
        try {
            $sql = "DELETE FROM reclamation_q WHERE id_reclamation = :id_reclamation";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':id_reclamation' => $id_reclamation]);
            return $stmt->rowCount() > 0 ? "Réclamation supprimée avec succès !" : "Aucune réclamation trouvée avec cet ID.";
        } catch (PDOException $e) {
            return 'Erreur : ' . $e->getMessage();
        }
    }
    public function historiqueReclamations($id_client) {
        try {
            $sql = "SELECT id_reclamation, contenue, date FROM reclamation_q WHERE id_client = :id_client ORDER BY date DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':id_client' => $id_client]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erreur lors de la récupération de l'historique des réclamations: " . $e->getMessage());
        }
    }
    public function getReclamationById($id_reclamation) {
        try {
            $sql = "SELECT * FROM reclamation_q WHERE id_reclamation = :id_reclamation";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':id_reclamation' => $id_reclamation]);
            $reclamation = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($reclamation) {
                return $reclamation;
            } else {
                return "Aucune réclamation trouvée avec cet ID.";
            }
        } catch (PDOException $e) {
            return 'Erreur : ' . $e->getMessage();
        }
    }
    
}