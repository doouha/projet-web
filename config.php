 <?php 
        
        $dsn = 'mysql:host=localhost;dbname=gestion reclamation';  
        $username = 'root';  
        $password = '';  
        
        try {
            $con = new PDO($dsn, $username, $password);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Connexion réussie à la base de données.";
        } catch (PDOException $e) {
            echo 'Échec de la connexion : ' . $e->getMessage();
        }
        
        ?>
