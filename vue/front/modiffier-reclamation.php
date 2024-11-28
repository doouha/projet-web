<?php
$id_reclamation = isset($_GET['id']) ? $_GET['id'] : null;  
include 'C:\xampp\htdocs\projet web\controller\reclamation_qC.php';
$reclamationC = new ReclamationC($con);
$reclamation = $reclamationC->getReclamationById($id_reclamation);
$message = "";
if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'update':
            $message = $reclamationC->updateReclamation(
                $id_reclamation,  // ID de la réclamation
                $reclamation['id_client'],  // ID du client depuis la réclamation récupérée
                $_POST['comment'],  // Contenu du commentaire
                date('Y-m-d H:i:s') // Date actuelle
            );
            break;

        case 'delete':
            $message = $reclamationC->deleteReclamation($id_reclamation);
            break;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification de Réclamation</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/custom.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 30px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .client-info {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .client-info img {
            margin-right: 20px;
            border-radius: 50%;
        }

        .form-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        textarea {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 20px;
            resize: vertical;
        }

        .btn {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .btn:focus {
            outline: none;
        }

        .btn-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Modification de Réclamation</h1>

        <div class="client-info">
            <img src="photo1.jpeg" alt="Photo Client" height="100" width="100">
            <div>
                <p><strong>NOM:</strong> MR Dawahi</p>
                <p><strong>ID:</strong> 1146></p>
            </div>
        </div>

        <div class="form-container">
            <form action="" method="post">
                <label for="reclamation">Modifiez votre réclamation :</label>
                <textarea name="comment" id="reclamation" cols="100" rows="7"><?= isset($reclamation['contenue']) ? htmlspecialchars($reclamation['contenue']) : '' ?></textarea>
                <div class="btn-container">
        <input type="submit" name="action" value="update" class="btn">
        <input   type="submit" name="action" value="delete" class="btn" style="background-color: #dc3545;"  <a href="reclamation.front.php"></a>>
    </div>
</form>
            </form>
        </div>
    </div>

    <footer>
        <div class="footer-main">
            <div class="container">
                <!-- Contenu du footer inchangé -->
            </div>
        </div>
    </footer>

</body>
</html>
