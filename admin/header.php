<!DOCTYPE html>
<html>
  <head>
    <title>Panel administrateur</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="../assets/css/bootstrap.css" rel="stylesheet">
    <link href="../assets/css/bootstrap.css.map" rel="stylesheet">
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/bootstrap.min.css.map" rel="stylesheet">
    <link href="../assets/css/panel.css" rel="stylesheet">
    <link rel="icon" href="../assets/img/logosite.ico">
  </head>
  <body>
	<div class="header">
	     <div class="container">
	        <div class="row">
	           <div class="col-md-5">
	              <!-- Logo -->
	              <div class="logo">
	                 <h1><a href="accueil.php">Panel administrateur</a></h1>
	              </div>
	           </div>
	           <div class="col-md-7">
	              <div class="navbar navbar-inverse" role="banner">
	                  <nav class="collapse navbar-collapse bs-navbar-collapse navbar-right" role="navigation">
	                    <ul class="nav navbar-nav">
	                      <li class="dropdown">
	                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $_SESSION['login'];?> <b class="caret"></b></a>
	                        <ul class="dropdown-menu animated fadeInUp">
	                          <li><a href="../logout.php">Logout</a></li>
	                        </ul>
	                      </li>
	                    </ul>
	                  </nav>
	              </div>
	           </div>
	        </div>
	     </div>
	</div>

    <div class="page-content">
    	<div class="row">
		  <div class="col-md-2">
		  	<div class="sidebar content-box" style="display: block;">
                <ul class="nav">
                    <!-- Main menu -->
                    <li class="current"><a href="accueil.php"><i class="glyphicon glyphicon-home"></i> Accueil</a></li>
                    <li><a href="users.php"><i class="glyphicon glyphicon-list"></i> Utilisateurs</a></li>
                    <li><a href="upload.php"><i class="glyphicon glyphicon-list"></i> Upload des images</a></li>
                    <li><a href="subscriptions.php"><i class="glyphicon glyphicon-pencil"></i> Abonnements</a></li>


                    <li class="submenu">
                         <a href="#">
                            <i class="glyphicon glyphicon-pencil"></i> Ajouts et modifications d'ouvrages
                            <span class="caret pull-right"></span>
                         </a>
                         <ul>
                            <li><a href="books.php">Ouvrages</a></li>
                            <li><a href="writers.php">Auteurs</a></li>
                            <li><a href="categories.php">Catégories</a></li>
                            <li><a href="series.php">Séries d'ouvrage</a></li>
                        </ul>
                    </li>
                    <li><a href="leasings.php"><i class="glyphicon glyphicon-calendar"></i> Réservations</a></li>
                    <li><a href="../index.php"><i class="glyphicon glyphicon-home"></i> Retour au site</a></li>
                </ul>
             </div>
		  </div>
      <script src="https://code.jquery.com/jquery.js"></script>
      <script src="../assets/js/bootstrap.min.js"></script>
      <script src="../assets/js/custom.js"></script>