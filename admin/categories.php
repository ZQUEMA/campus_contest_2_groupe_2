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
                    <div class="panel-title ">Ajouter une catégories</div>
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
                                  <label for="InputName">Description</label>
                                  <textarea class="form-control" id="InputName" type="text" name="description" ></textarea>
                              </div>
                          </div>
                      </div>
                      <button type="submit" class="btn btn-success" name="categories">Créer</button>
                  </form>
              
            </div>
        </div>
    </div>

    <div class="row">
		  		<div class="col-md-12 panel-warning">
		  			<div class="content-box-header panel-heading">
	  					<div class="panel-title ">Liste des catégories</div>
		  			</div>
		  			<div class="content-box-large box-with-header">
                      <?php
                        $db->real_query("SELECT * FROM Categories");
                        $res = $db->use_result(); ?>

                        <div class="table">
                            <div class="tr">
                                <span class="th" style="width:35%;">Nom</span>
                                <span class="th" style="width:45%;">Description</span>
                                <span class="th" style="width:10%; text-align:center;">Actions</span>
                            </div>
                      <?php  while ($row = $res->fetch_assoc()) { ?>
                            <form class="tr" method="post" >
                                <span class="td"><input class="form-control" id="exampleInput" type="text" name="nameCat" value="<?php echo $row['name']; ?>" ></span>
                                <span class="td">
                                    <textarea class="form-control" id="exampleInput" type="text" name="descriptionCat" ><?php echo $row['description']; ?></textarea>
                                    <input class="form-control" id="exampleInput" type="hidden" name="IDCat" value="<?php echo $row['ID']; ?>" >
                                </span>
                                <span class="td" style="text-align:center;">
                                    <button type="submit" class="btn btn-primary btn-sm pull-left" name="modifyCat">Modifier</button>
                                    <button type="submit" class="btn btn-danger btn-sm" name="deleteCat">Supprimer</button>
                                </span>
                            </form>
                        <?php }?>
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