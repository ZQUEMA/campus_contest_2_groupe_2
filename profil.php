<!-- ici on insert le header qui contient la page request.php -->
<?php include 'header.php'; ?>
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
?><head>
	<title>Manga++</title>
</head>
	<section class="main clearfix">
		<section class="top">
			<div class="wrapper content_header clearfix">
				<h1 class="title">Profil</h1>
			</div>
		</section>
		<section class="wrapper">
			<div class="content">
				<?php 
					$session_user = $_SESSION['login'];
					$db->real_query("SELECT * FROM Users WHERE ID = (SELECT ID FROM Users WHERE email = '$session_user')");
					$res = $db->use_result();
					while ($row = $res->fetch_assoc()) {
						if ($row['gender'] == 'M') {
								$currentSexe = 'Homme';
								$currentSexeBDD = 'M'; 
								$sexe = 'Femme';
								$sexeBDD = 'F';
							} else {
								$currentSexe = 'Femme';
								$currentSexeBDD = 'F'; 
								$sexe = 'Homme';
								$sexeBDD = 'M';
							} 
						if ($row['gender'] == 'M') {
							$currentSexe = 'Homme';
							$currentSexeBDD = 'M'; 
							$sexe = 'Femme';
							$sexeBDD = 'F';
							} else {
								$currentSexe = 'Femme';
								$currentSexeBDD = 'F'; 
								$sexe = 'Homme';
								$sexeBDD = 'M';
							}
				?>
					<div class="card-body">
					<form method="post">
					<?php include('errors.php'); ?>
						<div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <label for="InputEmail">Adresse email</label>
										<input class="form-control" id="InputEmail" type="email" name="email" value="<?php echo $row['email']; ?>" >
										<input class="form-control" id="InputEmail" type="hidden" name="currentEmail" value="<?php echo $session_user; ?>" >
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <label for="InputName">Prénom</label>
                                        <input class="form-control" id="InputName" type="text" name="firstname" value="<?php echo $row['first_name']; ?>" >
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <label for="InputName">Nom</label>
                                        <input class="form-control" id="InputName" type="text" name="lastname" value="<?php echo $row['last_name']; ?>" >
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <label for="InputName">Date de naissance</label>
                                        <input class="form-control" id="InputName" type="date" name="birthdate" value="<?php echo $row['birthdate']; ?>" >
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-12">
										<select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="genderUsers">
											<option value="<?php echo $currentSexeBDD; ?>" selected="selected"><?php echo $currentSexe; ?></option>
											<option value="<?php echo $sexeBDD; ?>"><?php echo $sexe; ?></option>
										</select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <label for="InputPassword1">Mot de passe</label>
                                            <input class="form-control" id="InputPassword1" type="password" name="password_1" >
                                        </div>
                                        <div class="col-md-6">
                                            <label for="InputPassword1">Confirmer le mot de passe</label>
                                        <input class="form-control" id="InputPassword2" type="password" name="password_2" >
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block" name="profil">Valider</button>
						</form>
						</div>
					<?php } ?>
				</div>
			</section>
		</section>
</body>
</html>
<?php
			} else {
				header('Location: index.php');
			}
		}
	}
?>