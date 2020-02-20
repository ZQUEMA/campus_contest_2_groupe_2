<!-- ici on inclue la page header contant la page request.php -->
<?php include 'header.php'; ?>
<!-- ici on vérifie bien que la personne est soit membre ou soit admin pour afficher la page -->
<?php 
	if (empty($_SESSION['login'])) {
		header('Location: index.php');
		} else {
			if($_SESSION['login']) {
				$session_user = $_SESSION['login'];
				$member_check_query = "SELECT * FROM Users WHERE ID = (SELECT ID FROM Users WHERE email = '$session_user') AND administrator = 0 OR administrator = 1";
				$result = mysqli_query($db, $member_check_query);
				$member = mysqli_fetch_assoc($result);
				if ($member) {
?>
<head>
	<title>Manga++</title>
</head>
	<section class="main clearfix">
		<section class="top">
			<div class="wrapper content_header clearfix">
				<h1 class="title">Historique des achats</h1>
			</div>
		</section>
		<section class="wrapper">
			<div class="content">
				<div class="table">
					<div class="tr">						
						<span class="th">Nom du livre</span>
						<span class="th">Catégorie</span>
						<span class="th">Date de reservation</span>
						<span class="th">Date de début</span>
						<span class="th">Date de fin</span>
						<span class="th">Lieu de reservation</span>
						<span class="th">Réduction</span>
                        <span class="th">Prix</span>
						<span class="th">Abonnement</span>
						<span class="th">Status</span>
					</div>
					<?php 
					// On récupère l'email de la variable session pour voir qui est sur la page
						$session_user = $_SESSION['login'];
						$db->real_query("SELECT 
											(SELECT title FROM Books WHERE ID = Leasing.ID_Books) AS Title,
											(SELECT (SELECT name FROM Categories WHERE ID = Books.ID_Categories) FROM Books WHERE ID = Leasing.ID_Books) AS Categorie,
											(SELECT name FROM Subscriptions WHERE ID = Leasing.ID_Subscriptions) AS SubscriptionsName,
											(SELECT name FROM Status WHERE ID = Leasing.ID_Status) AS Status,
											ID_Subscriptions AS SubscriptionID,
											leasing_cost,
											end_date,
											start_date,
											leasing_date,
											discount,
											leasing_way
											FROM Leasing 
											WHERE ID_Users = (SELECT ID FROM Users WHERE email = '$session_user') 
											ORDER BY ID DESC");
						$res = $db->use_result();
						// Boucle pour afficher tous l'hisorique de commande du user
						while ($row = $res->fetch_assoc()) {
					?>
					<form class="tr">
						<!-- si le champs est vide dans la BDD on ecrit un message a la place de laisser vide -->
                        <span class="td"><?php 
                        if (!isset($row['Title'])){
                            echo 'Cet ouvrage n&apos;existe plus !';
							} else {
								echo $row['Title'];
							}
                        ?></span>
						<span class="td"><?php echo $row['Categorie'];?></span>
						<span class="td"><?php echo $row['leasing_date'];?></span>
						<span class="td"><?php echo $row['start_date'];?></span>
						<span class="td"><?php echo $row['end_date'];?></span>
						<span class="td"><?php echo $row['leasing_way']; ?></span>
						<span class="td"><?php 
							if ($row['discount'] == 0) {
								echo 'Aucune réduction'; 
								} else {
									echo $row['discount'].' %'; 
								}
						?></span>
                        <span class="td"><?php echo $row['leasing_cost'].' €';?></span>
						<span class="td"><?php echo $row['SubscriptionsName'];?></span>
						<span class="td"><?php echo $row['Status'];?></span>			
					</form>
					<?php } ?>
				</div>
			</div>
		</section>
	</section>
</body>
</html>
<!-- Fin de la vérification, on renvoie sur la page index.php si la personne n'est pas admin ou membre -->
<?php
			} else {
				header('Location: index.php');
			}
		}
	}
?>