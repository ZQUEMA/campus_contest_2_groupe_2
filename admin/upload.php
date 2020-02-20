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
	  					<div class="panel-title ">Upload image</div>
		  			</div>
		  			<div class="content-box-large box-with-header">
					  <?php
						// Constantes
						define('TARGET', 'img/');    // Repertoire cible
						define('MAX_SIZE', 1000000);    // Taille max en octets du fichier
						define('WIDTH_MAX', 99999);    // Largeur max de l'image en pixels
						define('HEIGHT_MAX', 99999);    // Hauteur max de l'image en pixels
						
						// Tableaux de donnees
						$tabExt = array('jpg','gif','png','jpeg','jfif');    // Extensions autorisees
						$infosImg = array();
						
						// Variables
						$extension = '';
						$message = '';
						$nomImage = '';
						
						/************************************************************
						 * Creation du repertoire cible si inexistant
						*************************************************************/
						if( !is_dir(TARGET) ) {
						if( !mkdir(TARGET, 0755) ) {
							exit('Erreur : le répertoire cible ne peut-être créé ! Vérifiez que vous diposiez des droits suffisants pour le faire ou créez le manuellement !');
						}
						}
						
						/************************************************************
						 * Script d'upload
						*************************************************************/
						if(!empty($_POST))
						{
						// On verifie si le champ est rempli
						if( !empty($_FILES['fichier']['name']) )
						{
							// Recuperation de l'extension du fichier
							$extension  = pathinfo($_FILES['fichier']['name'], PATHINFO_EXTENSION);
						
							// On verifie l'extension du fichier
							if(in_array(strtolower($extension),$tabExt))
							{
							// On recupere les dimensions du fichier
							$infosImg = getimagesize($_FILES['fichier']['tmp_name']);
						
							// On verifie le type de l'image
							if($infosImg[2] >= 1 && $infosImg[2] <= 14)
							{
								// On verifie les dimensions et taille de l'image
								if(($infosImg[0] <= WIDTH_MAX) && ($infosImg[1] <= HEIGHT_MAX) && (filesize($_FILES['fichier']['tmp_name']) <= MAX_SIZE))
								{
								// Parcours du tableau d'erreurs
								if(isset($_FILES['fichier']['error']) 
									&& UPLOAD_ERR_OK === $_FILES['fichier']['error'])
								{
									// On renomme le fichier
									$nomImage = md5(uniqid()) .'.'. $extension;
						
									// Si c'est OK, on teste l'upload
									if(move_uploaded_file($_FILES['fichier']['tmp_name'], TARGET.$nomImage))
									{
									$desc = mysqli_real_escape_string($db, $_POST['desc']);
									echo "URL de l'image ";
									$url = 'admin/img/'.$nomImage;
									echo $url;
									$sql = "INSERT INTO Img (url, nom) VALUES('$url', '$desc')";
									// var_dump($sql); die();
									mysqli_query($db,$sql);
									$message = "Upload réussi !";
									}
									else
									{
									// Sinon on affiche une erreur systeme
									$message = 'Problème lors de l\'upload !';
									}
								}
								else
								{
									$message = 'Une erreur interne a empêché l\'uplaod de l\'image';
								}
								}
								else
								{
								// Sinon erreur sur les dimensions et taille de l'image
								$message = 'Erreur dans les dimensions de l\'image !';
								}
							}
							else
							{
								// Sinon erreur sur le type de l'image
								$message = 'Le fichier à uploader n\'est pas une image !';
							}
							}
							else
							{
							// Sinon on affiche une erreur pour l'extension
							$message = 'L\'extension du fichier est incorrecte !';
							}
						}
						else
						{
							// Sinon on affiche une erreur pour le champ vide
							$message = 'Veuillez remplir le formulaire svp !';
						}
						}
						?>
						<?php
							if( !empty($message) ) 
							{
								echo '<p>',"\n";
								echo "\t\t<strong>", htmlspecialchars($message) ,"</strong>\n";
								echo "\t</p>\n\n";
							}
							?>
							<form enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
							<fieldset>
								<legend>Formulaire</legend>
								<p>
									<div class="col-md-10">
										<label for="fichier_a_uploader" title="Recherchez le fichier à uploader !">Envoyer le fichier :</label>
										<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_SIZE; ?>" />
										<input name="fichier" type="file" id="fichier_a_uploader" />
										<div style="width:70%;"><br>
											Nom de l'image :
											<input class="form-control" id="desc" type="text" name="desc" >
										</div>
											<div style="width:20%; padding-top:10px;">
											<input type="submit" class="btn btn-primary btn-block" name="submit" value="Upload" />
										</div>
									</div>
								</p>
							</fieldset>
							</form> 	
					</div>
					<div class="content-box-upload">
					<?php
                        $db->real_query("SELECT * FROM Img");
                        $res = $db->use_result();

                        while ($row = $res->fetch_assoc()) { ?>
								<div class="block_img">
									<div class="desc_img"> <?php echo $row['nom']; ?></div>
									<img class="img_upload" src="../<?php echo $row['url'];?>"alt="<?php echo $row['nom'];?>">
								<div class="url_img"><a title=" <?php echo $row['nom']; ?>" href="../<?php echo $row['url']; ?>"> <?php echo $row['url']; ?></a>
								</div>
							</div>
                       <?php }
                    ?>
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