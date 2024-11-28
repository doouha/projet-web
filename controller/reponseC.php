<?php
include 'C:\xampp\htdocs\projet web\config.php';

class ReponseC {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function readReponses() {
        try {
            $sql = "SELECT * FROM reclamation_r";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erreur lors de la récupération des réponses: " . $e->getMessage());
        }
    }

    public function getLastId() {
        try {
            $sql = "SELECT MAX(id_reponse) AS last_id FROM reclamation_r";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['last_id'] !== null ? $result['last_id'] + 1 : 1;
        } catch (PDOException $e) {
            return 'Erreur : ' . $e->getMessage();
        }
    }

    public function addReponse($id_reclamation, $reponse) {
        try {
            $id_reponse = $this->getLastId();
            $date = date('Y-m-d H:i:s'); 

            $sql = "INSERT INTO reclamation_r (id_reponse, id_reclamation, reponse, date)
                    VALUES (:id_reponse, :id_reclamation, :reponse, :date)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':id_reponse' => $id_reponse,
                ':id_reclamation' => $id_reclamation,
                ':reponse' => $reponse,
                ':date' => $date
            ]);
            return "Réponse ajoutée avec succès !";
        } catch (PDOException $e) {
            return 'Erreur : ' . $e->getMessage();
        }
    }

    public function updateReponse($id_reponse, $id_reclamation, $reponse, $date) {
        try {
            $sql = "UPDATE reclamation_r SET 
                    reponse = :reponse, 
                    date = :date 
                    WHERE id_reponse = :id_reponse AND id_reclamation = :id_reclamation";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':reponse' => $reponse,
                ':date' => $date,
                ':id_reponse' => $id_reponse,
                ':id_reclamation' => $id_reclamation
            ]);
            return "Réponse mise à jour avec succès !";
        } catch (PDOException $e) {
            return 'Erreur : ' . $e->getMessage();
        }
    }

    public function deleteReponse($id_reponse) {
        try {
            $sql = "DELETE FROM reclamation_r WHERE id_reponse = :id_reponse";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':id_reponse' => $id_reponse]);
            return $stmt->rowCount() > 0 ? "Réponse supprimée avec succès !" : "Aucune réponse trouvée avec cet ID.";
        } catch (PDOException $e) {
            return 'Erreur : ' . $e->getMessage();
        }
    }
}
$reponseController = new ReponseC($con);
$message = "";
if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'add':
            $message = $reponseController->addReponse(
                $_POST['id_reclamation'],
                $_POST['reponse']
            );
            break;

        case 'update':
            $message = $reponseController->updateReponse(
                $_POST['id_reponse'],
                $_POST['id_reclamation'],
                $_POST['reponse'],
                $_POST['date']
            );
            break;

        case 'delete':
            $message = $reponseController->deleteReponse($_POST['id_reponse']);
            break;
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Réponses</title>
</head>
<body>
    <h1>Gestion des Réponses</h1>

    <!-- Affichage du message -->
    <?php if ($message): ?>
        <p><strong><?php echo $message; ?></strong></p>
    <?php endif; ?>

    <!-- Formulaire pour ajouter une réponse -->
    <form action="test_reponse.php" method="POST">
        <h2>Ajouter une Réponse</h2>
        <label for="id_reclamation">ID Réclamation :</label>
        <input type="number" name="id_reclamation" id="id_reclamation" required><br><br>

        <label for="reponse">Réponse :</label>
        <textarea name="reponse" id="reponse" required></textarea><br><br>

        <button type="submit" name="action" value="add">Ajouter</button>
    </form>

    <!-- Formulaire pour mettre à jour une réponse -->
    <form action="test_reponse.php" method="POST">
        <h2>Mettre à Jour une Réponse</h2>
        <label for="id_reponse_update">ID Réponse :</label>
        <input type="number" name="id_reponse" id="id_reponse_update" required><br><br>

        <label for="id_reclamation_update">ID Réclamation :</label>
        <input type="number" name="id_reclamation" id="id_reclamation_update" required><br><br>

        <label for="reponse_update">Nouvelle Réponse :</label>
        <textarea name="reponse" id="reponse_update" required></textarea><br><br>

        <label for="date_update">Date (YYYY-MM-DD HH:MM:SS) :</label>
        <input type="text" name="date" id="date_update" required><br><br>

        <button type="submit" name="action" value="update">Mettre à jour</button>
    </form>

    <!-- Formulaire pour supprimer une réponse -->
    <form action="test_reponse.php" method="POST">
        <h2>Supprimer une Réponse</h2>
        <label for="id_reponse_delete">ID Réponse :</label>
        <input type="number" name="id_reponse" id="id_reponse_delete" required><br><br>

        <button type="submit" name="action" value="delete">Supprimer</button>
    </form>

    <!-- Formulaire pour afficher les réponses -->
    <form action="test_reponse.php" method="POST">
        <h2>Afficher les Réponses</h2>
        <button type="submit" name="action" value="read">Afficher toutes les réponses</button>
    </form>
</body>
</html>
