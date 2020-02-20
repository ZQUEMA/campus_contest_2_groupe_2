<?php include '../assets/config/request.php';?>
<!-- Test si le user et bien admin ou non -->
<?php 
	if (empty($_SESSION['login'])) {
		header('Location: ../index.php');
	} else {
		if($_SESSION['login']) {
			$session_user = $_SESSION['login'];
			$admin_check_query = "SELECT * FROM Users WHERE ID = (SELECT id FROM Users WHERE email = '$session_user') and administrator = 1";
			$result = mysqli_query($db, $admin_check_query);
			$admin = mysqli_fetch_assoc($result);
			if ($admin) {
				include 'header.php';
?>
		  <div class="col-md-10">
		  	<div class="row">
		  		<div class="col-md-12 panel-warning">
		  			<div class="content-box-header panel-heading">
	  					<div class="panel-title ">Listes des utilisateurs</div>
		  			</div>
		  			<div class="content-box-large box-with-header">
						  <?php
						  $sub = "SELECT * FROM Subscriptions";
						  $result2 = mysqli_query($db,$sub);
						  while ($ligne=mysqli_fetch_array($result2)){
							  $subscriptions[$ligne['ID']] = $ligne['name'];
						  }

							$db->real_query(
								"SELECT 
									ID,
									first_name,
									last_name,
									email,
									birthdate,
									gender,
									administrator,
									ID_Subscriptions,
									number_leasing,
									ban,
									(SELECT name FROM Subscriptions WHERE ID = Users.ID_Subscriptions) AS CurrentSubscription
								FROM Users" );
							$res = $db->use_result();
							
							?>
							<div class="table">
								<div class="tr">
									<span class="th" style="width:23%;">Prénom</span>
									<span class="th" style="width:23%;">Nom</span>
									<span class="th" style="width:23%;">Email</span>
									<span class="th" style="width:5%;">Anniversaire</span>
									<span class="th" style="width:10%;">Sexe</span>
									<span class="th" style="width:10%;">Abonnement</span>
									<span class="th" style="width:5%;">Total emprunt</span>
									<span class="th" style="width:5%;">Banni ou non</span>
									<span class="th" style="width:10%; text-align:center;">Actions</span>
								</div>
								<?php
								while ($req = $res->fetch_assoc()) {
									$currentSubscription = $req['CurrentSubscription'];
									$idSubscription = $req['ID_Subscriptions'];
									if ($req['administrator'] == 1)
										{
											$rank = 'Administrateur';
										} else 
										{
											$rank = 'Membre';
										}
									if ($req['ban'] == 1)
									{
										$ban = 'Banni';
									} else 
									{
										$ban = 'Non Banni';
									}
									if ($req['gender'] == 'M')
									{
										$currentSexe = 'Homme';
										$currentSexeBDD = 'M'; 
										$sexe = 'Femme';
										$sexeBDD = 'F';
									} else 
									{
										$currentSexe = 'Femme';
										$currentSexeBDD = 'F'; 
										$sexe = 'Homme';
										$sexeBDD = 'M';
									}
									if ($req['gender'] == 'M')
									{
										$currentSexe = 'Homme';
										$currentSexeBDD = 'M'; 
										$sexe = 'Femme';
										$sexeBDD = 'F';
									} else 
									{
										$currentSexe = 'Femme';
										$currentSexeBDD = 'F'; 
										$sexe = 'Homme';
										$sexeBDD = 'M';
									} ?>
	
										<form class="tr" method="post">
											<span class="td"><input class="form-control" id="exampleInput" type="text" name="firstnameUsers" value="<?php echo $req['first_name']; ?>" ></span>
											<span class="td"><input class="form-control" id="exampleInput" type="text" name="lastnameUsers" value="<?php echo $req['last_name']; ?>" ></span>
											<span class="td"><input class="form-control" id="exampleInput" type="email" name="emailUsers" value="<?php echo $req['email']; ?>" ></span>
											<span class="td"><input class="form-control" id="exampleInput" type="date" name="birthdateUsers" value="<?php echo $req['birthdate']; ?>" ></span>
											<input class="form-control" id="exampleInput" type="hidden" name="IDUsers" value="<?php echo $req['ID']; ?>" ></span>
											<span class="td" style="text-align:center;">
												<select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="genderUsers">
													<option value="<?php echo $currentSexeBDD; ?>" selected="selected"><?php echo $currentSexe; ?></option>
													<option value="<?php echo $sexeBDD; ?>"><?php echo $sexe; ?></option>
												</select>
											</span>
											<span class="td" style="text-align:center;">
												<select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="subscritionUsers">
													<option value="<?php echo $idSubscription ?>" selected="selected"><?php echo $currentSubscription; ?></option>
													<?php
														foreach($subscriptions as $key => $value){
															if ($currentSubscription != $value) { ?>
																<option value="<?php echo $key ; ?>"><?php echo $value; ?></option>
															<?php } 
														}?>
												</select>
											</span>
											<span class="td"><?php echo $req['number_leasing']; ?></span>
											<span class="td"><?php echo $ban; ?><input class="form-control" id="exampleInput" type="hidden" name="Ban" value="<?php echo $ban; ?>" ></span>
											<span class="td" style="text-align:center;">
												<button type="submit" class="btn btn-primary btn-sm pull-left" name="modifyUsers">Modifier</button>
												<button type="submit" class="btn btn-danger btn-sm" name="banUsers">Bannir/Débannir</button>
												<?php if ($req['administrator'] == 1)
													{
														echo '<button type="submit" class="btn btn-primary" name="member">Changer le grade en : Membre</button>';
													} else
													{
														echo '<button type="submit" class="btn btn-primary" name="admin">Changer le grade en : Administrateur</button>';
													} ?>
											</span>
										</form>	
								<?php		
									}
								?>
							</div>	
					</div>
		  		</div>
		  	</div>
		  </div>
		</div>
    </div>
    <?php include 'footer.php';?>
  </body>
</html>
<?php
			} else {
				header('Location: ../membre/accueil.php');
			}
		}
	}
?>