<?php
include '../config.php';
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
            $id_reclamation = $this->getLastId(); // Génération du nouvel ID
            $date = date('Y-m-d H:i:s'); // Date actuelle
    
            // Préparation et exécution de la requête d'insertion
            $sql = "INSERT INTO reclamation_q (id_reclamation, id_client, contenue, date)
                    VALUES (:id_reclamation, :id_client, :contenue, :date)";
            $stmt = $this->db->prepare($sql);
    
            if ($stmt->execute([
                ':id_reclamation' => $id_reclamation,
                ':id_client' => $id_client,
                ':contenue' => $contenue,
                ':date' => $date
            ])) {
                // Appel de la méthode historiqueReclamations après insertion
                $historique = $this->historiqueReclamations($id_client);
    
                // Retour du message de succès et de l'historique
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
    

    public function updateReclamation($id_reclamation, $contenue) {
        try {
            $date = date('Y-m-d H:i:s');
    
            $sql = "UPDATE reclamation_q SET
                    date = :date,
                    contenue = :contenue
                    WHERE id_reclamation = :id_reclamation";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':date' => $date,
                ':contenue' => $contenue,
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
}

// Instanciation de la classe
$reclamationController = new ReclamationC($con);

// Gestion des actions utilisateur
$message = "";
$historique = [];
if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'add':
            $message = $reclamationController->addReclamation(
                $_POST['id_client'],
                $_POST['contenue']
            );
            $historique = $message['historique'];
            break;

        case 'update':
            $message = $reclamationController->updateReclamation(
                $_POST['id_reclamation'],
                $_POST['contenue'],
            );
            break;

        case 'delete':
            $message = $reclamationController->deleteReclamation($_POST['id_reclamation']);
            break;
    }
}

// Récupération des réclamations
$reclamations = $reclamationController->readReclamations();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Réclamations</title>
</head>
<body>
    <h2>Gestion des Réclamations</h2>


    <!-- Liste des réclamations -->
    <h3>Liste des Réclamations</h3>
    <table border="1">
        <tr>
            <th>ID Réclamation</th>
            <th>ID Client</th>
            <th>Contenu</th>
            <th>Date</th>
        </tr>
        <?php foreach ($reclamations as $reclamation): ?>
        <tr>
            <td><?= htmlspecialchars($reclamation['id_reclamation']) ?></td>
            <td><?= htmlspecialchars($reclamation['id_client']) ?></td>
            <td><?= htmlspecialchars($reclamation['contenue']) ?></td>
            <td><?= htmlspecialchars($reclamation['date']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <!-- Formulaire pour ajouter une réclamation -->
    <h3>Ajouter une Réclamation</h3>
    <form method="POST" id="recl">
        <input type="hidden" name="action" value="add">
        <input type="text" name="id_client" placeholder="ID Client" required id="id_client">
        <textarea name="contenue" placeholder="Contenu" required></textarea id="contenue">
        <button type="submit">Ajouter</button>
    </form>

<?php if (!empty($historique)): ?>
    <h3>Historique des Réclamations pour le client <?= htmlspecialchars($_POST['id_client']) ?></h3>
    <table border="1">
        <thead>
            <tr>
                <th>ID Réclamation</th>
                <th>Contenu</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($historique as $reclamation): ?>
                <tr>
                <td><a href="../vue/front/modiffier-reclamation.php?id=<?= htmlspecialchars($reclamation['id_reclamation']) ?>"> <?= htmlspecialchars($reclamation['id_reclamation']) ?> </a></td>

                <td><?= htmlspecialchars($reclamation['contenue']) ?></td>
                <td><?= htmlspecialchars($reclamation['date']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php elseif (!empty($_POST['id_client'])): ?>
    <p>Aucune réclamation trouvée pour ce client.</p>
<?php endif; ?>


    <!-- Formulaire pour mettre à jour une réclamation -->
    <h3>Mettre à jour une Réclamation</h3>
    <form method="POST">
    <!-- Champ masqué pour identifier la réclamation -->
    <input type="hidden" name="action" value="update">
    <input type="text" name="id_reclamation" required  placeholder="id_reclamation" <?= htmlspecialchars($id_reclamation) ?>>
    
    <!-- Champ pour le contenu à modifier -->
    <textarea name="contenue" placeholder="Contenu" required><?= htmlspecialchars($reclamation['contenue']) ?></textarea>
    
    <!-- Bouton pour soumettre le formulaire -->
    <button type="submit">Mettre à jour</button>
</form>


    <!-- Formulaire pour supprimer une réclamation -->
    <h3>Supprimer une Réclamation</h3>
    <form method="POST">
        <input type="hidden" name="action" value="delete">
        <input type="text" name="id_reclamation" placeholder="ID Réclamation" required>
        <button type="submit">Supprimer</button>
    </form>
</body>
</html>

