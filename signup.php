<!-- ici on insert le header qui contient la page request.php -->
<?php include 'header.php';?>
	<section class="main clearfix">
		<section class="top">	
			<div class="wrapper content_header clearfix">
				<h1 class="title">Inscription</h1>
			</div>		
		</section>
		<section class="wrapper">
			<div class="content">
                <div class="card mx-auto mt-5">
                    <div class="card-body">
                        <form method="post">
                            <?php include('errors.php'); ?>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <label for="InputEmail">Adresse email</label>
                                        <input class="form-control" id="InputEmail" type="email"  name="email" value="<?php echo $email; ?>" >
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <label for="InputName">Prénom</label>
                                        <input class="form-control" id="InputName" type="text"   name="firstname" value="<?php echo $firstname; ?>" >
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <label for="InputName">Nom</label>
                                        <input class="form-control" id="InputName" type="text"   name="lastname" value="<?php echo $lastname; ?>" >
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <label for="InputName">Date de naissance</label>
                                        <input class="form-control" id="InputName" type="date"   name="birthdate" value="<?php echo $birthdate; ?>" >
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <label for="InputName">Sexe</label><br>
                                        <input name="gender" type="radio" value="M" > Homme<br>
                                        <input name="gender" type="radio" value="F"> Femme
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
                            <button type="submit" class="btn btn-primary btn-block" name="reg_user">Valider</button>
                        </form>
                    <div class="text-center">
                        <a class="d-block small mt-3" href="login.php">Page de connexion</a>
                    </div>
                </div>
			</div>
		</section>
	</section>	
</body>
</html>