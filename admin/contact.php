<?php include '../assets/config/request.php';?>
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
		  			<div class="content-box-header">
	  					<div class="panel-title ">Messages reçus</div>
						
						<div class="panel-options">
							<a href="#" data-rel="collapse"><i class="glyphicon glyphicon-refresh"></i></a>
							<a href="#" data-rel="reload"><i class="glyphicon glyphicon-cog"></i></a>
						</div>
		  			</div>
		  			<div class="content-box-contact box-with-header">
					  <?php
					  	if (isset($_POST['ok'])) {
							$id = mysqli_real_escape_string($db, $_POST['id']);
							$sql = "UPDATE commentaire SET archive = 1 WHERE id = $id";
							$result = mysqli_query($db,$sql);
					}
                        $mysqli->real_query("SELECT * FROM commentaire WHERE archive = 0");
                        $res = $mysqli->use_result();

                        while ($row = $res->fetch_assoc()) { ?>
							<div class="block_contact">
								<div class="nom_contact">Nom: <?php echo  $row['nom']; ?></div>
								<div class="tel_contact">Tel: <?php echo  $row['tel']; ?></div>
								<div class="email_contact">Email: <?php echo  $row['email']; ?></div><br>
								<div class="txt_msg_contact">Message:</div><br>
								<div class="msg_contact"><?php echo $row['message']; ?></div>
								<form method="post" action="contact.php">	<input class="form-control" id="exampleInput" type="hidden" name="id" value="	<?php echo $row['id']; ?>	" >	<div class="btn_contact">	<button type="submit" class="btn btn-primary btn-block" name="ok">Archiver</button></div>
								</form>
                            </div>
                        <?php }  ?>
					</div>
		  		</div>
		  	</div>
			  <div class="row">
		  		<div class="col-md-12 panel-warning">
		  			<div class="content-box-header">
	  					<div class="panel-title ">Messages archiver</div>
						
						<div class="panel-options">
							<a href="#" data-rel="collapse"><i class="glyphicon glyphicon-refresh"></i></a>
							<a href="#" data-rel="reload"><i class="glyphicon glyphicon-cog"></i></a>
						</div>
		  			</div>
		  			<div class="content-box-contact box-with-header">
					  <?php
                        $mysqli->real_query("SELECT * FROM commentaire WHERE archive = 1");
                        $res = $mysqli->use_result();

                        while ($row = $res->fetch_assoc()) { ?>
							<div class="block_contact">
								<div class="nom_contact">Nom: <?php echo  $row['nom']; ?></div>
								<div class="tel_contact">Tel: <?php echo  $row['tel']; ?></div>
								<div class="email_contact">Email: <?php echo  $row['email']; ?></div>
								<br>
								<div class="txt_msg_contact">Message:</div>
								<br>
								<div class="msg_contact"><?php echo $row['message']; ?></div>
							</div>
                        <?php } ?>
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