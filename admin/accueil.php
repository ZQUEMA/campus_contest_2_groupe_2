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
			  <div class="content-box-large">
                <h3>Bienvenue sur le panneau de contrôle administrateur.</h3>
                <p>Comme vous pouvez le voir, sur la gauche il y a un tableau avec plusieurs fonctionnalités.</p>
                <br />
                <h5><b>UTILISATEURS</b></h5> 
                <p> Ici vous pourrez modifier le <b>Prénom,Nom,Email,Date d'anniversaire,Sexe,Abonnement</b></p>.
                <br />
                <h5><b>UPLOAD DES IMAGES</b></h5> 
                <p>Celle ci vous permettra d'<b>upload vos images depuis votre ordinateur, tablette, téléphone.</b><br/>
                Vous pourrez ensuite utiliser le <b>lien généré sous les images</b> afin de les coller dans l'encoche prévu au panel <b>Ouvrages</b>.</p>
                <br />
                <h5><b>ABONNEMENTS</b></h5> 
                <p>Dans ce panel, il vous sera possible de <b>crée, modifier ou supprimer un abonnement</b>. Mais aussi de <b>modifier les abonnements</b>, comme le nombre des emprunts, la durée de l'abonnement etc...</p>
                <br />
                <h5><b>AJOUTS ET MODIFICATION D'OUVRAGES</b></h5>
                <p>Dans cette section vous aurez la possibilité de faire plusieurs choses. Vous pourrez <b>crée, éditer ou supprimer les Ouvrages, les Auteurs, les Catégories, les Séries d'ouvrages.</b></p>
				<br />
                <h5><b>RÉSERVATIONS</b></h5>
                <p>Ici vous pourrez <b>modifier l'états des réservations (les valider, les supprimer, les modifier).</b></p>
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