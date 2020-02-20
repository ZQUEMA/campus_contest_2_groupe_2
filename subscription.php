<!-- ici on insert le header qui contient la page request.php -->
<?php include 'header.php'; ?>
<section class="main clearfix">
	<section class="top">
		<div class="wrapper content_header clearfix">
			<h1 class="title">Abonnements</h1>
		</div>
	</section>
	<section class="wrapper">
		<div class="content">
			<div class="table">
				<div class="tr">
					<span class="th" style="width:20%;"></span>
					<span class="th" style="width:10%;">Durée de l'abonnement</span>
					<span class="th" style="width:5%;">Nombre de livre</span>
					<span class="th" style="width:10%;">Durée de l'empreint</span>
					<span class="th" style="width:10%;">Prix de l'abonnement</span>
					<span class="th" style="width:10%;">Prix de la location par livre</span>
				</div>
				<?php 
					$db->real_query("SELECT * FROM Subscriptions");
					$res = $db->use_result();
					while ($row = $res->fetch_assoc()) {
				?>
				<form class="tr">
					<span class="td">
					<?php
						if ($row['ID'] == 1) {
							echo $row['name'].' (Abonnement par defaut)';
							} else {
								echo $row['name'];
							}
					?>
					</span>
					<span class="td"><?php echo $row['subscriptions_time'].' jours';?></span>
					<span class="td"><?php echo $row['book_amount'];?></span>
					<span class="td"><?php echo $row['leasing_duration'].' jours';?></span>
					<span class="td">
					<?php 
						if (empty($row['subscription_cost'])) {
							echo '';
							} else {
								echo $row['subscription_cost'].' €';
							}
					?>
					</span>
					<span class="td">
					<?php 
						if (empty($row['book_cost'])) {
							echo '';
							} else {
								echo $row['book_cost'].' €';
							}
					?>
					</span>
				</form>
				<?php } ?>
			</div>
		</div>
	</section>
</section>
</body>
</html>