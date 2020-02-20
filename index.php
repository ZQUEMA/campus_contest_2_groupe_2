<!-- Insersation du header qui contient la page request.php -->
<?php include 'header.php';?>
	<section class="main clearfix">
		<?php
		// Requette SQL FROM Books
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
							(SELECT name FROM Series WHERE ID = Books.ID_Series) AS serieName
						FROM Books 
						LEFT JOIN Series 
						ON Series.ID = Books.ID_Series");
		$res = $db->use_result();
			// Boucle pour afficher tous les ouvrages avec les images nom et stock
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
								// Sinon on affiche une images par defaut si le champs img dans la BDD est vide
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
							<!-- Affichage du nom et du stock -->
							<h1><?php echo $req['title'].'<br>Stock : '.$amount;  ?></h1>
						</div>
					</div>
					</a>
				</div>
				<!-- On ferme la boucle while -->
				<?php } ?>
 	</section>
</body>
</html>