<!-- On inclue le header qui contient la page request.php -->
<?php include 'header.php';?>
	<section class="main clearfix">
		<section class="top">	
			<div class="wrapper content_header clearfix">
				<h1 class="title">Connexion</h1>
			</div>		
		</section>
		<section class="wrapper">
			<div class="content">
                <div class="card mx-auto mt-5">
                    <div class="card-body">
                        <form method="post" action="login.php">
                            <!-- ici on affiche les erreur reçus depuis request.php -->
                            <?php include('errors.php'); ?>
                            <!-- ici on envoie l'email saisie sur la page request qui est inclu ici -->
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email</label>
                                <input class="form-control"  type="text" name="email">
                            </div>
                            <!-- ici on envoie le mot depasse saisie sur la page request qui est inclu ici -->
                            <div class="form-group">
                                <label for="exampleInputPassword1">Mot de passe</label>
                                <input class="form-control"  type="password" name="password">
                            </div>
                            <button type="submit" class="btn btn-primary btn-block" name="login_user">Connexion</button>
                        </form>
                        <!-- ici on redirige vers la page d'inscription -->
                    <div class="text-center">
                        <a class="d-block small mt-3" href="signup.php">Page d'inscription</a>
                    </div>
                </div>
			</div>
		</section>
	</section>
</body>
</html>