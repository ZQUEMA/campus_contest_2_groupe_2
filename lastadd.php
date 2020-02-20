<!-- On insert le header qui contient la page request.php -->
<?php include 'header.php'; ?>
<!-- Ici on verifie que la personne bien un admin ou un membre -->
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
				<h1 class="title">6 dernier ajout</h1>
			</div>
		</section>
		<section class="wrapper">
			<div class="content clearfix">
			<?php
			// Requette sql FROM Books
			$db->real_query("SELECT 
								Books.title,
								Books.ID,
								Books.img,
								(SELECT name FROM Img WHERE Books.img = Img.url) as ImgName,
								(SELECT name FROM Categories WHERE ID = Books.ID_Categories) AS Categorie,
								Books.releasing_year,
								Books.description,
								(SELECT amount FROM Stocks WHERE ID_Books = Books.ID) AS amount,
								(SELECT first_name FROM Writers WHERE ID = Books.ID_Writers) AS firstnameWriter,
								(SELECT last_name FROM Writers WHERE ID = Books.ID_Writers) AS lastnameWriter,
								(SELECT name FROM Series WHERE ID = Books.ID_Series) AS Series
							FROM Books 
							LEFT JOIN Series 
							ON Series.ID = Books.ID_Series
							ORDER BY ID DESC LIMIT 6");
			$res = $db->use_result();
			// Boucle while qui affiche les 6 dernier ajout d'ouvrage trouver dans la BDD grace a la requette si dessus
				while ($req = $res->fetch_assoc()){?>
					<div class="work">
						<a href="page.php?livre=<?php echo $req['ID'];  ?>">
						<?php
							if (!empty($req['img'])){
								if (!empty('ImgName')){
									echo '<img src="'.$req['img'].'" class="media" alt="'.$req['ImgName'].'"/>';
									} else {
										echo '<img url="'.$req['img'].'" class="media" alt=""/>';
									}
								} else {
									echo '<img src="admin/img/5d82c66168e653441a64b9b5e67c4da2.png" class="media" alt="Unknow"/>';
								}
							// Affichage du stock vide ou non
							if ($req['amount'] == 0) {
								$amount = 'Vide';
								} else {
									$amount = $req['amount'];
								}
						?>
						<div class="caption">
							<div class="work_title">
								<h1><?php echo $req['title'].'<br>Stock : '.$amount;  ?></h1>
							</div>
						</div>
					</a>
				</div>
				<?php } ?>
			</div>
		</section>
	</section>
</body>
</html>
<!-- Ici on ferme la balise ouverte au tous début du document, on renvoie sur l'index.php si la personne n'est ni connecter en membre ou admin -->
<?php
		} else {
			header('Location: index.php');
		}
	}
}
?>