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
					<div class="panel-title ">Ajouter un ouvrage</div>
				</div> 
				<div class="content-box-large box-with-header">
				<form method="post">
					<?php include('../errors.php'); ?>
					<div class="form-group">
						<div class="form-row">
							<div class="col-md-12">
								<label for="InputName">Titre</label>
								<input class="form-control" id="InputName" type="text" name="title" >
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="form-row">
							<div class="col-md-12">
								<label for="InputName">Catégories</label><br>
								
									<?php
										$db->real_query("SELECT * FROM Categories");
										$res = $db->use_result();
										while ($row = $res->fetch_assoc()) {
											$id = $row['ID'];
											$name = $row['name'];
											echo'<input type="radio" name="idCategories" value="'.$id.'"> '.$name."&emsp;</option>";
										}
									?>
								
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="form-row">
							<div class="col-md-12">
								<label for="InputName">Année de parution</label>
								<input class="form-control" id="InputName" type="number" min="0" name="releasing_year" >
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
					  <div class="form-group">
						<div class="form-row">
							<div class="col-md-12">
								<label for="InputName">Nombre de livre</label>
								<input class="form-control" id="InputName" type="number" min="0" name="numberBook" >
							</div>
						</div>
					</div>
					  <div class="form-group">
						<div class="form-row">
							<div class="col-md-12">
								<label for="InputName">URL de l'image</label>
								<input class="form-control" id="InputName" type="text" name="img" >
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="form-row">
							<div class="col-md-12">
							<br><button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseWriter" aria-expanded="false" aria-controls="collapseWriter">Auteurs</button>
								<div class="collapse" id="collapseWriter">
  									<div class="card card-body">
											<?php
												$db->real_query("SELECT * FROM Writers");
												$res = $db->use_result();
												while ($row = $res->fetch_assoc()) {
													$id = $row['ID'];
													$firstname = $row['first_name'];
													$lastname = $row['last_name'];

													if (!empty($lastname)){
														echo '<input type="radio" name="idWriter" value="'.$id.'"> '.$firstname.' '.$lastname.'&emsp;';
													} else {
														echo '<input type="radio" name="idWriter" value="'.$id.'"> '.$firstname.'&emsp;';
													}
												}
											?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="form-row">
							<div class="col-md-12">
							<br><button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseSerie" aria-expanded="false" aria-controls="collapseSerie">Série</button>
								<div class="collapse" id="collapseSerie">
  									<div class="card card-body">
									  <?php
										$db->real_query("SELECT * FROM Series");
										$res = $db->use_result();
										while ($row = $res->fetch_assoc()) {
											$id = $row['ID'];
											$name = $row['name'];
											echo'<input type="radio" name="idSerie" value="'.$id.'"> '.$name."&emsp;</option>";
										}
									?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<button type="submit" class="btn btn-success" name="addBooks">Créer</button>
				</form>
            </div>	
		</div>
	</div>
	
	</div>
	</div>

	<div class="row">
		<div class="col-md-12 panel-warning">
			<div class="content-box-header panel-heading">
				<div class="panel-title ">Liste des ouvrages</div>
			</div>
			<div class="content-box-large box-with-header">
						<?php
						$cat = "SELECT * FROM Categories";
						$result2 = mysqli_query($db,$cat);
						while ($ligne=mysqli_fetch_array($result2)){
							$categories[$ligne['ID']] = $ligne['name'];
						}

						$wri = "SELECT * FROM Writers";
						$result3 = mysqli_query($db,$wri);
						while ($ligne=mysqli_fetch_array($result3)){
							$writer[$ligne['ID']] = $ligne['first_name'].' '.$ligne['last_name'];
						}

						$sto = "SELECT * FROM Stocks";
						$result3 = mysqli_query($db,$sto);
						while ($ligne=mysqli_fetch_array($result3)){
							$stocks[$ligne['ID_Books']] = $ligne['amount'];
						}

						$ser = "SELECT * FROM Series";
						$result4 = mysqli_query($db,$ser);
						while ($ligne=mysqli_fetch_array($result4)){
							$serie[$ligne['ID']] = $ligne['name'];
						}
						$db->real_query(
							"SELECT 
							Books.title,
							Books.ID,
							Books.img,
							Books.copies_number AS NbBooks,
							(SELECT name FROM Categories WHERE ID = Books.ID_Categories) AS CurrentCategorie,
							(SELECT ID FROM Categories WHERE ID = Books.ID_Categories) AS IDCategorie,
							(SELECT first_name FROM Writers WHERE ID = Books.ID_Writers) AS firstnameWriter,
							(SELECT last_name FROM Writers WHERE ID = Books.ID_Writers) AS lastnameWriter,
							(SELECT ID FROM Writers WHERE ID = Books.ID_Writers) AS IDWriter,
							(SELECT name FROM Series WHERE ID = Books.ID_Series) AS CurrentSerie,
							(SELECT ID FROM Series WHERE ID = Books.ID_Series) AS IDSerie,
							Books.releasing_year,
							Books.description,
							(SELECT first_name FROM Writers WHERE ID = Books.ID_Writers) AS firstnameWriter,
							(SELECT last_name FROM Writers WHERE ID = Books.ID_Writers) AS lastnameWriter
							FROM Books 
							LEFT JOIN Series 
							ON Series.ID = Books.ID_Series");
							$res = $db->use_result(); ?>

							

							<div class="table">
								<div class="tr">
									<span class="th" style="width:10%; text-align:center;">Titre</span>
									<span class="th" style="width:5%; text-align:center;">Catégorie</span>
									<span class="th" style="width:2%; text-align:center;">Année de parution</span>
									<span class="th" style="width:15%; text-align:center;">Description</span>
									<span class="th" style="width:1%; text-align:center;">Nombre de livre</span>
									<span class="th" style="width:1%; text-align:center;">Nombre de livre en stock</span>
									<span class="th" style="width:10%; text-align:center;">URL image</span>
									<span class="th" style="width:4%; text-align:center;">Auteur</span>
									<span class="th" style="width:3%; text-align:center;">Séries</span>
									<span class="th" style="width:7%; text-align:center;">Actions</span>
								</div>

							<?php while ($req = $res->fetch_assoc()){
								$id = $req['ID'];
								$title = $req['title'];
								$idCategorie = $req['IDCategorie'];
								$currentCategories = $req['CurrentCategorie'];
								$idWriter = $req['IDWriter'];
								$currentWriters = $req['firstnameWriter'].' '.$req['lastnameWriter'];
								$releasing_year = $req['releasing_year'];
								$NbBooks = $req['NbBooks'];
								$description = $req['description'];
								$firstnameWriter = $req['firstnameWriter'];
								$lastnameWriter = $req['lastnameWriter'];
								$url = $req['img'];
								if (!empty($req['IDSerie'])){
									$currentSerie = $req['CurrentSerie'];
									$idSerie = $req['IDSerie'];
								} else {
									$idSerie = NULL;
								} ?>
								<form class="tr" method="post">
									<span class="td"><input class="form-control" id="exampleInput" type="text" name="title" value="<?php echo $title; ?>" ></span>
									<span class="td" style="text-align:center;">
										<select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="Categories">
											<option value="<?php echo $idCategorie; ?>" selected="selected"><?php echo $currentCategories; ?></option>
											<?php	foreach($categories as $key => $value){
													if ($currentCategories != $value) {
														echo '<option value="'.$key.'">'.$value.'</option>';
													}
												} ?>
										</select>
									</span>
									<span class="td"><input class="form-control" id="exampleInput" type="text" name="releasing_year" value="<?php echo $releasing_year; ?>" ></span>
									<span class="td"><textarea class="form-control" id="exampleInput" type="text" name="description" ><?php echo $description; ?></textarea></span>
									<span class="td"><input class="form-control" id="exampleInput" type="text" name="NbBooks" value="<?php echo $NbBooks; ?>" ></span>
									<span class="td">
									<?php	foreach($stocks as $key => $value){
											if ($id == $key) {
												echo $value;
											}
										}?>
									</span>
									<span class="td"><textarea class="form-control" id="exampleInput" type="text" name="url" ><?php echo $url ?></textarea></span>
									<span class="td" style="text-align:center;">
									<select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="IDWriter">
										<option value="<?php echo $idWriter ?>" selected="selected"><?php echo $currentWriters ?></option>
										<?php	foreach($writer as $key => $value){
												if ($currentWriters != $value) {
													echo '<option value="'.$key.'">'.$value.'</option>';
												}
											} ?>
									</select>
									</span>
									<input class="form-control" id="exampleInput" type="hidden" name="IDBook" value="<?php echo $id ?>" ></span>
									<span class="td" style="text-align:center;">
										<select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="IDSerie">
											<?php	if (isset($idSerie)){
													echo '<option value="'.$idSerie.'" selected="selected">'.$currentSerie.'</option>';
												} else {
													echo '<option value="" selected="selected">Vide</option>';
												}
												foreach($serie as $key => $value){
													if ($currentSerie != $value) {
														echo '<option value="'.$key.'">'.$value.'</option>';
													}
												} ?>
										</select>
									</span>
									<span class="td" style="text-align:center;">
										<button type="submit" class="btn btn-primary btn-sm pull-left" name="modifyBook">Modifier</button>
										<button type="submit" class="btn btn-danger btn-sm" name="deleteBook">Supprimer</button>
									</span>
								</form>	
							<?php } ?>
						</div>'
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