<?php
include 'C:\xampp\htdocs\projet web\controller\reclamation_qC.php';
$reclamationController = new ReclamationC($con);

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
}
}
?>




<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Réclamation Client</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/custom.css">
    <style>
        .logo {
            width: 120px;
            height: auto;
        }
        .navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 0;
        }
    </style>
</head>
<body>
    <header class="main-header">
        <nav class="navbar navbar-expand-lg navbar-light bg-light navbar-default bootsnav">
            <div class="container">
                <div class="navbar-header">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-menu">
                        <i class="fa fa-bars"></i>
                    </button>
                    <a class="navbar-brand" href="index.html"><img src="images/logo.png" class="logo" alt=""></a>
                </div>
                <div class="collapse navbar-collapse" id="navbar-menu">
                    <ul class="nav navbar-nav ml-auto">
                        <li class="nav-item"><a class="nav-link" href="index.html">Home</a></li>
                        <li class="nav-item active"><a class="nav-link" href="contact-us.html">Contact Us</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="container">
        <h1 align="center">Réclamation</h1>


            <div align="center">
            <form method="POST" id="recl">
        <input type="hidden" name="action" value="add">
        <input type="text" name="id_client" placeholder="ID Client" required id="id_client">
        <textarea name="contenue" placeholder="Contenu" required></textarea id="contenue">
        <button type="submit">Ajouter</button>
    </form>

<!-- Message qui s'affiche après la validation -->
<div id="reclamation_message" class="global-message"></div>

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
                <td><a href="modiffier-reclamation.php?id=<?= htmlspecialchars($reclamation['id_reclamation']) ?>"> <?= htmlspecialchars($reclamation['id_reclamation']) ?> </a></td>
                <td><?= htmlspecialchars($reclamation['contenue']) ?></td>
                <td><?= htmlspecialchars($reclamation['date']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php elseif (!empty($_POST['id_client'])): ?>
    <p>Aucune réclamation trouvée pour ce client.</p>
<?php endif; ?>


       <footer>
        <div class="footer-main">
            <div class="container">
				<div class="row">
					<div class="col-lg-4 col-md-12 col-sm-12">
						<div class="footer-top-box">
							<h3>Business Time</h3>
							<ul class="list-time">
								<li>Monday - Friday: 08.00am to 05.00pm</li> 
								<li>Saturday: 10.00am to 08.00pm</li> 
								<li>Sunday: <span>Closed</span></li>
							</ul>
						</div>
					</div>
					<div class="col-lg-4 col-md-12 col-sm-12">
						<div class="footer-top-box">
							<h3>Newsletter</h3>
							<form class="newsletter-box">
								<div class="form-group">
									<input class="" type="email" name="Email" placeholder="Email Address*" />
									<i class="fa fa-envelope"></i>
								</div>
								<button class="btn hvr-hover" type="submit">Submit</button>
							</form>
						</div>
					</div>
					<div class="col-lg-4 col-md-12 col-sm-12">
						<div class="footer-top-box">
							<h3>Social Media</h3>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
							<ul>
                                <li><a href="#"><i class="fab fa-facebook" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fab fa-twitter" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fab fa-linkedin" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fab fa-google-plus" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-rss" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fab fa-pinterest-p" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fab fa-whatsapp" aria-hidden="true"></i></a></li>
                            </ul>
						</div>
					</div>
				</div>
				<hr>
                <div class="row">
                    <div class="col-lg-4 col-md-12 col-sm-12">
                        <div class="footer-widget">
                            <h4>About Freshshop</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p> 
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p> 							
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 col-sm-12">
                        <div class="footer-link">
                            <h4>Information</h4>
                            <ul>
                                <li><a href="#">About Us</a></li>
                                <li><a href="#">Customer Service</a></li>
                                <li><a href="#">Our Sitemap</a></li>
                                <li><a href="#">Terms &amp; Conditions</a></li>
                                <li><a href="#">Privacy Policy</a></li>
                                <li><a href="#">Delivery Information</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 col-sm-12">
                        <div class="footer-link-contact">
                            <h4>Contact Us</h4>
                            <ul>
                                <li>
                                    <p><i class="fas fa-map-marker-alt"></i>Address: Michael I. Days 3756 <br>Preston Street Wichita,<br> KS 67213 </p>
                                </li>
                                <li>
                                    <p><i class="fas fa-phone-square"></i>Phone: <a href="tel:+1-888705770">+1-888 705 770</a></p>
                                </li>
                                <li>
                                    <p><i class="fas fa-envelope"></i>Email: <a href="mailto:support@domain.com">support@domain.com</a></p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="footer-text text-left">
                            <p>&copy; 2024 FreshShop - All Rights Reserved</p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="footer-text text-right">
                            <p>Designed by <a href="https://www.technext.it">Technext</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    
</body>
</html>
