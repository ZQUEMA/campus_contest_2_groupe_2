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
                    <div class="panel-title ">Ajouter un abonnement</div>
                </div> 
                <div class="content-box-large box-with-header">
                  <form method="post">
                      <?php include('../errors.php'); ?>
                      <div class="form-group">
                          <div class="form-row">
                              <div class="col-md-12">
                                  <label for="InputName">Nom</label>
                                  <input class="form-control" id="InputName" type="text" name="name" >
                              </div>
                          </div>
                      </div>
                      <div class="form-group">
                          <div class="form-row">
                              <div class="col-md-12">
                                  <label for="InputName">Temps (en jour) de l'abonnement</label>
                                  <input class="form-control" id="InputName" type="number" name="subscriptions_time" >
                              </div>
                          </div>
                      </div>
                      <div class="form-group">
                          <div class="form-row">
                              <div class="col-md-12">
                                  <label for="InputName">Nombre de livre empruntable avec l'abonement</label>
                                  <input class="form-control" id="InputName" type="number" name="book_amount" >
                              </div>
                          </div>
                      </div>
                      <div class="form-group">
                          <div class="form-row">
                              <div class="col-md-12">
                                  <label for="InputName">Temps (en jour) de l'empreint</label>
                                  <input class="form-control" id="InputName" type="number" name="leasing_time" >
                              </div>
                          </div>
                      </div>
                      <div class="form-group">
                          <div class="form-row">
                              <div class="col-md-12">
                                  <label for="InputName">Prix de l'abonnement (Peut ne pas être renseigné)</label>
                                  <input class="form-control" id="InputName" type="number" name="price" >
                              </div>
                          </div>
                      </div>
                      <div class="form-group">
                          <div class="form-row">
                              <div class="col-md-12">
                                  <label for="InputName">Prix de la location par livre </label>
                                  <input class="form-control" id="InputName" type="number" name="book_cost" >
                              </div>
                          </div>
                      </div>
                      
                         <button type="submit" class="btn btn-success" name="subscription">Créer</button>
                  </form>
              
            </div>
        </div>
    </div>

    <div class="row">
		  		<div class="col-md-12 panel-warning">
		  			<div class="content-box-header panel-heading">
	  					<div class="panel-title ">Liste des abonnements</div>
		  			</div>
		  			<div class="content-box-large box-with-header">
                      <?php
                        $db->real_query("SELECT * FROM Subscriptions");
                        $res = $db->use_result(); ?>

                        <div class="table">
                            <div class="tr">
                                <span class="th" style="width:15%;">Nom</span>
                                <span class="th" style="width:7%;">Durée de l&apos;abonement</span>
                                <span class="th" style="width:5%;">Nombre de livre</span>
                                <span class="th" style="width:7%;">Durée de l\'empreint</span>
                                <span class="th" style="width:7%;">Prix de l&apos;abonement</span>
                                <span class="th" style="width:7%;">Prix de la location par livre</span>
                                <span class="th" style="width:5%; text-align:center;">Actions</span>
                            </div>
                       <?php
                        while ($row = $res->fetch_assoc()) { ?>
                            <form class="tr" method="post">
                                <span class="td"><input class="form-control" id="exampleInput" type="text" name="name" value="<?php echo $row['name']; ?>" ></span>
                                <span class="td"><input class="form-control" id="exampleInput" type="text" name="subscriptions_time" value="<?php echo $row['subscriptions_time']; ?>" ></span>
                                <span class="td"><input class="form-control" id="exampleInput" type="text" name="book_amount" value="<?php echo $row['book_amount']; ?>" ></span>
                                <span class="td"><input class="form-control" id="exampleInput" type="text" name="leasing_time" value="<?php echo $row['leasing_duration']; ?>" ></span>
                                <span class="td"><input class="form-control" id="exampleInput" type="text" name="price" value="<?php echo $row['subscription_cost']; ?>" ></span>
                                <span class="td">
                                    <input class="form-control" id="exampleInput" type="text" name="book_cost" value="<?php echo $row['book_cost']; ?>" >
                                    <input class="form-control" id="exampleInput" type="hidden" name="IDSubscription" value="<?php echo $row['ID']; ?>" >
                                </span>
                                <span class="td" style="text-align:center;">
                                    <button type="submit" class="btn btn-primary btn-sm pull-left" name="modifySubscriptions">Modifier</button>
                                    <button type="submit" class="btn btn-danger btn-sm" name="deleteSubscriptions">Supprimer</button>
                                </span>
                            </form>
                       <?php } ?>
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