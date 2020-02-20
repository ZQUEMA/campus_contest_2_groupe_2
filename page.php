<!-- ici on insert la page header.php qui contient la page request.php -->
<?php include 'header.php';?>
<head>
	<title>Manga++</title>
</head>
<?php
	// requette sql qui va chercher tous le livre ayant l'id reçus de la methode get
	$sql = "SELECT * FROM Books WHERE ID=".$_GET['livre'];
	$result = mysqli_query($db, $sql);
	$book = mysqli_fetch_assoc($result); 
	// requette sql qui va recupérer les stocks du livre
	$sql = "SELECT * FROM Stocks WHERE ID_Books=".$_GET['livre'];
	$result = mysqli_query($db, $sql);
	$copies = mysqli_fetch_assoc($result); 
	// requette sql qui va recupérer l'auteur du livre
	$sql = "SELECT * FROM Writers WHERE ID=".$book['ID_Writers'];
	$result = mysqli_query($db, $sql);
	$writer = mysqli_fetch_assoc($result);
	// on récupère la date du jour
	$today= getdate();
	$day = $today['mday'];
	$month = $today['mon'];
	$year = $today['year'];
	// on verfie que la personne est bien connecter avec une adresse email valide
	if(isset($_SESSION['login'])) {
		$session_user = $_SESSION['login'];
		$sql = "SELECT * FROM Users WHERE ID = (SELECT id FROM Users WHERE email = '$session_user')";
		$result = mysqli_query($db, $sql);
		$user = mysqli_fetch_assoc($result);
	}

	?>
	<section class="main clearfix">
		<section class="top">	
			<div class="wrapper content_header clearfix">
				<h1 class="title"><?php echo $book['title']; ?></h1>
			</div>		
		</section>
		<section class="wrapper">
			<div class="content">
			<span class="imgpage">
				<!-- On affiche l'image du livre -->
				<?php 
				if (!empty($book['img'])){
					if (!empty('ImgName')){
						echo '<img src="'.$book['img'].'" class="media" alt="'.$book['title'].'"/>';
						} else {
							echo '<img url="'.$book['img'].'" class="media" alt=""/>';
						}
					} else {
						echo '<img src="admin/img/5d82c66168e653441a64b9b5e67c4da2.png" class="media" alt="Unknow"/>';
					}
				if (isset($book['ID_Series'])){
					$sql = "SELECT * FROM Series WHERE ID=".$book['ID_Series'];
					$result = mysqli_query($db, $sql);
					$serie = mysqli_fetch_assoc($result);
					
				}
				?></span>
				<!-- On affiche un tableau qui contient les infos suivante : nom du livre, série, auteur et date de parution -->
			<span class="table">
				<div class="tr">						
					<span class="th">Nom du livre</span>
					<span class="th">Série</span>
					<span class="th">Auteur</span>
					<span class="th">Date de parution</span>
				</div>
				<div class="tr">
					<span class="td"><?php echo $book['title']; ?></span>
					<span class="td"><?php echo $serie['name']; ?></span>
					<span class="td">
						<?php 
							echo $writer['first_name'];
								if (isset($writer['last_name'])){
									echo " ".$writer['last_name'];
								} 
						?>
					</span>
					<span class="td"><?php echo $book['releasing_year']; ?></span>		
				</div>
			</span>
			<h4>Description</h4><span class="tdd"><br><?php echo $book['description'] ;?></span>
			<hr>
			<h3> Je veux ce livre :</h3>
			<?php 
				if (empty($_SESSION['login'])) {
					echo '<a href="login.php">Connexion</a>';
				} else {
					if($copies['amount']>0){ ?>
						<p>Nombre d'exemplaire en stock : <?php echo $copies['amount']; ?></p>
						<?php
							if($_SESSION['login'])  {
								$sql ="SELECT 
											(SELECT ID FROM Subscriptions WHERE ID = Users.ID_Subscriptions) AS ID, 
											(SELECT name FROM Subscriptions WHERE ID = Users.ID_Subscriptions) AS Name,
											(SELECT book_amount FROM Subscriptions WHERE ID = Users.ID_Subscriptions) AS book_amount,
											(SELECT book_cost FROM Subscriptions WHERE ID = Users.ID_Subscriptions) AS book_cost,
											number_leasing
										FROM Users 
										WHERE ID=".$user['ID'];
								$result = mysqli_query($db, $sql);
								$subscriptions = mysqli_fetch_assoc($result);
								if ($user['ID_Subscriptions']==1){
									for($i=0; $i<=4; $i++){
										if (intval($subscriptions['number_leasing'])<($i+1)*10 && intval($subscriptions['number_leasing'])>=$i*10){
											$reduction = $i*10;
											break;
										} 
									}
									if (!isset($reduction)){
										$reduction=50;
									}
									$totalcost = floatval($subscriptions['book_cost'])*(1-($reduction/100));
								} else {
									$totalcost = floatval($subscriptions['book_cost']);
								}

								$today= getdate();
								if ($today['mday'] < 10){
									$day = "0".$today['mday'];
									} else {
										$day = $today['mday'];
									}
								if ($today['mon'] < 10){
									$month = "0".$today['mon'];
									} else {
										$month = $today['mon'];
									}
								if (($today['mon']+1) < 10){
									$nextMonth = "0".($today['mon']+1);
									} else {
										$nextMonth = ($today['mon']+1);
									}
								$year = $today['year'];
								$min="$year-$month-$day";
								$max= "$year-$nextMonth-$day";
							?>
							<p>Avec votre Abonnement <?php echo $subscriptions['Name']; ?>, vous pouvez louer ce livre au prix de <?php echo $totalcost; ?>€<?php 
							if ($user['ID_Subscriptions']==1){ ?>
								avec une reduction de <?php echo $reduction; ?>% !
							<?php } else { 
							 }
								?></p>
								<?php if ($user['leasing_together'] < $subscriptions['book_amount']){ ?>
									<form method="post">
										<input  type="hidden" name="userID" value="<?php echo $user['ID']; ?>" >
										<input  type="hidden" name="bookID" value="<?php echo $book['ID']; ?>" >
										<input  type="hidden" name="leasing_date" value="<?php echo $min ?>" >
										<label>A partir du : <input  type="date" min="<?php echo $min; ?>" max="<?php echo $max; ?>"name="starting_date" ></label>
										<button type="submit" class="btn btn-primary btn-sm pull-left" name="toBook">Réserver ce livre</button>
									</form>
									<?php } else { ?>
									<p>Vous avez atteint le nombre maximum d'emprunt en simultané</p>
									<?php }	
							}
						} else { ?>
							<p>Désolé, il n'y a plus d'exemplaire en stocks</p>
						<?php
						}
					}
				?>
			</div>
		</section>
	</section>
</body>
</html>
