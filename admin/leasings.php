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
                    <div class="panel-title ">Créer une réservation</div>
                </div> 
                <div class="content-box-large box-with-header">
                  <form method="post">
                      <?php include('../errors.php'); ?>
                      <div class="form-group">
                          <div class="form-row">
                              <div class="col-md-12">
                                  <label for="InputName">Ouvrage</label>
                                  <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="bookID">
                                    <?php
                                        $boo = "SELECT * FROM Books";
                                        $result2 = mysqli_query($db,$boo);
                                        while ($ligne=mysqli_fetch_array($result2)){
                                            $books[$ligne['ID']] = $ligne['title'];
                                        }
                                        $sto = "SELECT * FROM Stocks";
                                        $result2 = mysqli_query($db,$sto);
                                        while ($ligne=mysqli_fetch_array($result2)){
                                            $stocks[$ligne['ID_Books']] = $ligne['amount'];
                                        }
                                        foreach($books as $key => $value){ 
                                            $bookId = array_search($value, $books);
                                            if (intval($stocks[$key]) > 0){?>
                                                <option value="<?php echo $key ; ?>"><?php echo $value; ?></option>
                                            <?php
                                            }  
                                        }?>
                                  </select>
                              </div>
                          </div>
                      </div>
                      <div class="form-group">
                          <div class="form-row">
                              <div class="col-md-12">
                                  <label for="InputName">Client</label>
                                  <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="userID">
                                    <?php
                                        $sub = "SELECT * FROM Users";
                                        $result2 = mysqli_query($db,$sub);
                                        while ($ligne=mysqli_fetch_array($result2)){
                                            $users[$ligne['ID']] = $ligne['email'];
                                            $userBan[$ligne['ID']] = $ligne['ban'];
                                        }
                                        foreach($users as $key => $value){ 
                                            if (intval($userBan[$key])==0){?>
                                                <option value="<?php echo $key ; ?>"><?php echo $value; ?></option>
                                            <?php } 
                                        }?>
                                  </select>
                              </div>
                          </div>
                      </div>
                      <div class="form-group">
                          <div class="form-row">
                              <div class="col-md-12">
                              <?php 
                              $today= getdate();
                              if ($today['mday'] < 10){
                                  $day = "0".$today['mday'];
                              } else {
                                  $day = $today['mday'];
                              }
                              if ($today['mon'] < 10){
                                  $month = "0".$today['mon'];
                              } else {
                                  $month = $today['mon'];
                              }
                              if (($today['mon']+1) < 10){
                                  $nextMonth = "0".($today['mon']+1);
                              } else {
                                  $nextMonth = ($today['mon']+1);
                              }
                              $year = $today['year'];
                              $min="$year-$month-$day";
                              $max= "$year-$nextMonth-$day";
                              ?>
								    <input  type="hidden" name="leasing_date" value="<?php echo $min ?>" >
								    <input  type="hidden" name="toBookAdmin" value="true" >
                                    <label>A partir du : <input  type="date" min="<?php echo $min; ?>" max="<?php echo $max; ?>"name="starting_date" ></label>
                              </div>
                          </div>
                      </div>
                      <button type="submit" class="btn btn-success" name="toBook">Créer</button>
                  </form>
              
            </div>
        </div>
    </div>
</div>
</div>

    <div class="row">
		  		<div class="col-md-12 panel-warning">
		  			<div class="content-box-header panel-heading">
	  					<div class="panel-title ">Liste des réservations</div>
		  			</div>
		  			<div class="content-box-large box-with-header">
                        <div class="table">
                            <div class="tr">
                                <span class="th" style="width:8%;">Date de la commande</span>
                                <span class="th" style="width:15%;">Titre du livre</span>
                                <span class="th" style="width:5%;">Réduction</span>
                                <span class="th" style="width:5%;">Prix</span>
                                <span class="th" style="width:15%;">Client</span>
                                <span class="th" style="width:8%;">Date du début</span>
                                <span class="th" style="width:8%;">Date de fin</span>
                                <span class="th" style="width:5%;">Lieu de reservation</span>
                                <span class="th" style="width:10%; text-align:center;">Status</span>
                                <span class="th" style="width:15%; text-align:center;">Actions</span>
                            </div>
                            <?php
                                $sta = "SELECT * FROM Status";
                                $result2 = mysqli_query($db,$sta);
                                while ($ligne=mysqli_fetch_array($result2)){
                                    $status[$ligne['ID']] = $ligne['name'];
                                }
                                $db->real_query(
                                    "SELECT 
                                        ID,
                                        start_date,
                                        end_date,
                                        leasing_date,
                                        ID_Status,
                                        ID_Books,
                                        leasing_cost,
                                        leasing_way,
                                        discount,
                                        ID_Users,
                                        (SELECT email FROM Users WHERE Leasing.ID_Users = Users.ID) AS email,
                                        (SELECT title FROM Books WHERE Leasing.ID_Books = Books.ID) AS title,
                                        (SELECT name FROM Status WHERE Leasing.ID_Status = Status.ID) AS status
                                    FROM Leasing");
                                $res = $db->use_result();
                                while ($row = $res->fetch_assoc()) { ?>
                                    <form class="tr" method="post" >
                                        <span class="td"><?php echo $row['leasing_date']; ?></span>
                                        <span class="td"><?php
                                        if (!isset($row['title'])){
                                            echo 'Cet ouvrage n&apos;existe plus !';
                                        } else {
                                            echo $row['title'];
                                        }
                                        ?></span>
                                        <span class="td"><?php 
                                            if ($row['discount'] == 0) {
                                                echo 'Aucune réduction'; 
                                            } else {
                                                echo $row['discount'].' %'; 
                                            }
                                        ?></span>
                                        <span class="td"><?php echo $row['leasing_cost'].' €'; ?></span>
                                        <span class="td"><?php echo $row['email']; ?></span>
                                        <span class="td"><?php echo $row['start_date']; ?></span>
                                        <span class="td"><?php echo $row['end_date']; ?></span>
                                        <span class="td"><?php echo $row['leasing_way']; ?></span>
                                        <span class="td" style="text-align:center;">
                                            <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="ID_Status">
                                                <option value="<?php echo $row['status']; ?>" selected="selected"><?php echo $row['status']; ?></option>
                                                <?php
                                                    foreach($status as $key => $value){
                                                        if ($row['status'] != $value) { ?>
                                                            <option value="<?php echo $key ; ?>"><?php echo $value; ?></option>
                                                        <?php } 
                                                    }?>
                                            </select>
                                        </span>
                                        <span class="td" style="text-align:center;">
											<input class="form-control" id="exampleInput" type="hidden" name="ID" value="<?php echo $row['ID']; ?>" >
											<input class="form-control" id="exampleInput" type="hidden" name="ID_Users" value="<?php echo $row['ID_Users']; ?>" >
											<input class="form-control" id="exampleInput" type="hidden" name="ID_Books" value="<?php echo $row['ID_Books']; ?>" >
											<button type="submit" class="btn btn-primary btn-sm pull-left" name="modifyLeasing">Modifier</button>
                                            <button type="submit" class="btn btn-danger btn-sm" name="deleteLeasing">Supprimer</button>
                                        </span>
                                    </form>
                                <?php } ?>
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