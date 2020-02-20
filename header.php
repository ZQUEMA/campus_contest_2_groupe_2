<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0" />
	<link rel="stylesheet" type="text/css" href="assets/css/reset.css">
	<link rel="stylesheet" type="text/css" href="assets/css/main.css">
    <script type="text/javascript" src="assets/js/jquery.js"></script>
	<script type="text/javascript" src="assets/js/main.js"></script>
	<link rel="icon" href="assets/img/logosite.ico">
</head>
<body>
<?php include 'assets/config/request.php';?>
	<header>
		<!-- Logo du site -->
		<div class="logo">
			<a href="index.php"><img src="assets/img/logo.png" title="Manga++" alt="Manga++"/></a>
		</div>

		<div id="menu_icon"></div>
		<nav>
			<ul>
				<li><a href="index.php">Bibliothèque</a></li>
				<li><a href="lastadd.php">Dernier Ajout</a></li>
				<li><a href="subscription.php">Abonnements</a></li>
				<li><a href="contact.php">Contactez-nous</a></li>
				<?php 
                    if (empty($_SESSION['login'])) { ?>
                        <li><a href="login.php">Connexion</a></li>
                    <?php } else {
                        if($_SESSION['login']) {
                            $session_user = $_SESSION['login'];
                            $admin_check_query = "SELECT * FROM Users WHERE ID = (SELECT id FROM Users WHERE email = '$session_user') and administrator = 1";
                            $result = mysqli_query($db, $admin_check_query);
							$admin = mysqli_fetch_assoc($result);
							$quota_check_query = "SELECT leasing_together, (SELECT book_amount FROM Subscriptions WHERE ID = ID_Subscriptions) AS book_amount FROM Users WHERE ID = (SELECT id FROM Users WHERE email = '$session_user')";
                            $result = mysqli_query($db, $quota_check_query);
                            $quota = mysqli_fetch_assoc($result);
                            if ($admin) { ?>
								<li><a href="profil.php" class="button" title="profil">Profil</a></li>
								<li><a href="historical.php" class="button" title="historical">Historique</a></li>
								<li><a href="admin/accueil.php" class="button" title="Administration">Administration</a></li>
								<li><a href="logout.php" class="button" title="Deconnexion">Déconnexion</a></li>
								<li><br></li>
								<li>Nombre de réservation actuel: <?php echo $quota['leasing_together']; ?></li>
								<li>Nombre de réservation max : <?php echo $quota['book_amount']; ?></li>
                            <?php } else { ?>
								<li><a href="profil.php" class="button" title="profil">Profil</a></li>
								<li><a href="historical.php" class="button" title="historical">Historique</a></li>
								<li><a href="contact.php">Contactez-nous</a></li>
								<li><a href="logout.php" class="button" title="Deconnexion">Déconnexion</a></li>
								<li><br></li>
								<li>Nombre de réservation actuel: <?php echo $quota['leasing_together']; ?></li>
								<li>Nombre de réservation max : <?php echo $quota['book_amount']; ?></li>
                           <?php }
                        }
                    }
				?>
				
			</ul>
		</nav><!-- end navigation menu -->

		<div class="footer clearfix">
			<ul class="social clearfix">
				<li><a href="#" class="fb" data-title="Facebook"></a></li>
				<li><a href="#" class="google" data-title="Google +"></a></li>
				<li><a href="#" class="twitter" data-title="Twitter"></a></li>
			</ul><!-- end social -->

			<div class="rights">
				<p>Copyright © 2020 Manga++.</p>
			</div><!-- end rights -->
		</div ><!-- end footer -->
	</header><!-- end header -->