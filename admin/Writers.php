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
                    <div class="panel-title ">Ajouter un auteur</div>
                </div> 
                <div class="content-box-large box-with-header">
                  <form method="post">
                      <?php include('../errors.php'); ?>
                      <div class="form-group">
                          <div class="form-row">
                              <div class="col-md-12">
                                  <label for="InputName">Prénom</label>
                                  <input class="form-control" id="InputName" type="text" name="firstname" >
                              </div>
                          </div>
                      </div>
                      <div class="form-group">
                          <div class="form-row">
                              <div class="col-md-12">
                                  <label for="InputName">Nom</label>
                                  <input class="form-control" id="InputName" type="text" name="lastname" >
                              </div>
                          </div>
                      </div>
                      <div class="form-group">
                          <div class="form-row">
                              <div class="col-md-12">
                                  <label for="InputName">Sexe</label><br>
                                  <select class="selectpicker" id="inputGroupSelect01" name="gender">
                                  <option value="" selected="selected">Non définie</option>
                                  <option value="M">Homme</option>
                                  <option value="F">Femme</option>
                                  </select>
                              </div>
                          </div>
                      </div>
                      <button type="submit" class="btn btn-success" name="writer">Créer</button>
                  </form>
              
            </div>
        </div>
    </div>

    <div class="row">
		  		<div class="col-md-12 panel-warning">
		  			<div class="content-box-header panel-heading">
	  					<div class="panel-title ">Liste des auteurs</div>
		  			</div>
		  			<div class="content-box-large box-with-header">
                      <?php
                        $db->real_query("SELECT * FROM Writers");
                        $res = $db->use_result(); ?>

                        <div class="table">
                            <div class="tr">
                                <span class="th" style="width:30%;">Prénom</span>
                                <span class="th" style="width:30%;">Nom</span>
                                <span class="th" style="width:7%; text-align:center;">Sexe</span>
                                <span class="th" style="width:8%; text-align:center;">Actions</span>
                            </div>
                        <?php 
                        while ($req = $res->fetch_assoc()) {
                            if (!empty($req['gender'])){
                                if ($req['gender'] == 'M')
                                {
                                    $currentSexe = 'Homme';
                                    $currentSexeBDD = 'M'; 
                                    $sexe = 'Femme';
                                    $sexeBDD = 'F';
                                    $sexe2 = 'Non définie';
                                    $sexe2BDD = '';
                                } else 
                                {
                                    $currentSexe = 'Femme';
                                    $currentSexeBDD = 'F'; 
                                    $sexe = 'Homme';
                                    $sexeBDD = 'M';
                                    $sexe2 = 'Non définie';
                                    $sexe2BDD = '';
                                }
                            } else {
                                $currentSexe = 'Non définie';
                                $currentSexeBDD = ''; 
                                $sexe = 'Homme';
                                $sexeBDD = 'M';
                                $sexe2 = 'Femme';
                                $sexe2BDD = 'F';
                            } ?>
                            <form class="tr" method="post">
                                <span class="td"><input class="form-control" id="exampleInput" type="text" name="firstnameWriter" value="<?php echo $req['first_name']; ?>" ></span>
                                <span class="td">
                                    <input class="form-control" id="exampleInput" type="text" name="lastnameWriter" value="<?php echo $req['last_name']; ?>" >
                                    <input class="form-control" id="exampleInput" type="hidden" name="IDWriter" value="<?php echo $req['ID']; ?>" >
                                </span>
                                <span class="td" style="text-align:center;">
                                    <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="genderWriter">
                                        <option value="<?php echo $currentSexeBDD; ?>" selected="selected"><?php echo $currentSexe; ?></option>
                                        <option value="<?php echo $sexeBDD; ?>"><?php echo $sexe; ?></option>
                                        <option value="<?php echo $sexe2BDD; ?>"><?php echo $sexe2; ?></option>
                                    </select>
                                </span>
                                <span class="td" style="text-align:center;">
                                    <button type="submit" class="btn btn-primary btn-sm pull-left" name="modifyWriter">Modifier</button>
                                    <button type="submit" class="btn btn-danger btn-sm" name="deleteWriter">Supprimer</button>
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