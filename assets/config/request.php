<?php
include 'config.php';
$firstname    = "";
$lastname    = "";
$birthdate    = "";
$gender    = "";
$email    = "";
$errors = array();

////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////// USERS ////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////

// MODIFICATION PROFIL USER
if (isset($_POST['profil'])) {
    // Valeurs reçus du post
    $firstname = mysqli_real_escape_string($db, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($db, $_POST['lastname']);
    $birthdate = mysqli_real_escape_string($db, $_POST['birthdate']);
    $gender = mysqli_real_escape_string($db, $_POST['genderUsers']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $currentEmail = mysqli_real_escape_string($db, $_POST['currentEmail']);
    $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
    // On verifie si les mots de passe correspondent
    if ($password_1 != $password_2) { array_push($errors, "Les mots de passes ne correspondent pas"); }
    // S'il n'y a pas d'erreur en insert dans la DB
    if (count($errors) == 0) {
    $password = md5($password_1); //encryptage du MDP dans la DB
    if (empty($password_1)) { 
            $sql = "UPDATE Users SET first_name = '$firstname', last_name = '$lastname', email = '$email', birthdate = '$birthdate', gender = '$gender' WHERE email = '$currentEmail'";
     } else {
        $sql = "UPDATE Users SET first_name = '$firstname', last_name = '$lastname', email = '$email', birthdate = '$birthdate', password = '$password', gender = '$gender' WHERE email = '$currentEmail'";
     }
    //on lance la commande (mysqli_query)
    mysqli_query($db,$sql);
    }
    }


// INSCRIPTION USER
if (isset($_POST['reg_user'])) {
    // Valeurs reçus du post
    $firstname = mysqli_real_escape_string($db, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($db, $_POST['lastname']);
    $birthdate = mysqli_real_escape_string($db, $_POST['birthdate']);
    $gender = mysqli_real_escape_string($db, $_POST['gender']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
    // On verifie si c'est pas vide
    if (empty($firstname)) { array_push($errors, "Prénom requis"); }
    if (empty($lastname)) { array_push($errors, "Nom requis"); }
    if (empty($birthdate)) { array_push($errors, "Date de naissance requis"); }
    if (empty($gender)) { array_push($errors, "Sexe requis"); }
    if (empty($email)) { array_push($errors, "Email requis"); }
    if (empty($password_1)) { array_push($errors, "Mot de passe requis"); }
    if ($password_1 != $password_2) { array_push($errors, "Les mots de passes ne correspondent pas"); }
    // On verifie que l'email n'est pas déjà present dans la DB
    $user_check_query = "SELECT * FROM Users WHERE email='$email' LIMIT 1";
    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);
    if ($user)  {// si le user existe
    if ($user['email'] === $email) {
    array_push($errors, "Email déjà pris");
    }
    }
    // S'il n'y a pas d'erreur en insert dans la DB
    if (count($errors) == 0) {
    $password = md5($password_1); //encryptage du MDP dans la DB
    $sql = "INSERT INTO Users (first_name, last_name, email, birthdate, password, gender) VALUES('$firstname', '$lastname', '$email', '$birthdate', '$password', '$gender')";
    //on lance la commande (mysqli_query)
    mysqli_query($db,$sql);
    // on recupère la dernière clef étrangère
    // $user_id = mysqli_insert_id($db);
    // mysqli_free_result($result);
    // $sql = "INSERT INTO Users_infos (user_id, nom, prenom) VALUES ($user_id, '$name', '$username')";
    // $result = mysqli_query($db,$sql);
    // $_SESSION['success'] = "Vous êtes maintenant connecter";
    header('location: login.php');
    }
    }

// CONNEXION USER
if (isset($_POST['login_user'])) {
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
    $banni_check_query = "SELECT ban FROM Users WHERE email='$email'";
    $result = mysqli_query($db, $banni_check_query);
    $banni = mysqli_fetch_assoc($result);
    if ($banni)  {// si banni ou pas
        if ($banni['ban'] == 1 ) {
            array_push($errors, "Vous êtes banni !!");
            }
    }
    if (empty($email)) {
    array_push($errors, "Email requis");
    }
    if (empty($password)) {
    array_push($errors, "Mot de passe requis");
    }
    if (count($errors) == 0) {
    $password = md5($password);
    $query = "SELECT * FROM Users WHERE email='$email' AND password='$password'";
    $results = mysqli_query($db, $query);
    if (mysqli_num_rows($results) == 1) {
    $_SESSION['login'] = $email;
    header('location: index.php');
    } else {
    array_push($errors, "Mauvaise combinaison Email/Mot de passe");
    }
    }
    }
    

// Modifier le rank d'un user
if (isset($_POST['admin'])) {
    $id = $_POST['IDUsers'];
    $sql = "UPDATE Users SET administrator = 1 WHERE ID = $id";
    mysqli_query($db,$sql);
}

if (isset($_POST['member'])) {
    $id = $_POST['IDUsers'];
    $sql = "UPDATE Users SET administrator = 0 WHERE ID = $id";
    mysqli_query($db,$sql);
}

//Modifier un user
if (isset($_POST['modifyUsers'])) {
    $firstnameUser = $_POST['firstnameUsers'];
    $lastnameUser = $_POST['lastnameUsers'];
    $genderUser = $_POST['genderUsers'];
    $emailUser = $_POST['emailUsers'];
    $birthdateUser = $_POST['birthdateUsers'];
    $subscritionUser = $_POST['subscritionUsers'];
    $id = $_POST['IDUsers'];
    $sql = "UPDATE Users SET first_name = '$firstnameUser', last_name = '$lastnameUser', gender = '$genderUser', email = '$emailUser', birthdate = '$birthdateUser', ID_Subscriptions = $subscritionUser WHERE ID = $id";
    $result = mysqli_query($db,$sql);
}

//REQUETE DE SUPPRESSION USER
if (isset($_POST['banUsers'])){
// Valeurs reçus du post
$id = $_POST['IDUsers'];
$ban = $_POST['Ban'];
if ($ban == 'Banni') {
    $sql = "UPDATE Users SET ban = 0 WHERE ID=$id";
} else {
    $sql = "UPDATE Users SET ban = 1 WHERE ID=$id";
}
$result = mysqli_query($db,$sql);
}


////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////// AUTEURS ///////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Ajout d'un auteur dans la DB
if (isset($_POST['writer'])){
    // Valeurs reçus du post
    $firstname = mysqli_real_escape_string($db, $_POST['firstname']);
    if (isset($_POST['lastname'])){
        $lastname = mysqli_real_escape_string($db, $_POST['lastname']);
    }
    if (isset($_POST['gender'])){
        $gender = mysqli_real_escape_string($db, $_POST['gender']);
    }
    // On verifie si c'est pas vide
    if (empty($firstname)) { array_push($errors, "Prénom requis"); }
        // On verifie que le nom et le prénom n'est pas déjà present dans la DB
    $writer_check_query = "SELECT * FROM Writers WHERE first_name='$firstname' AND last_name='$lastname'";
    $result = mysqli_query($db, $writer_check_query);
    $writer = mysqli_fetch_assoc($result);
    if ($writer)  {// si le writer existe
        if ($writer['first_name'] == $firstname AND $writer['last_name'] == $lastname ) {
            array_push($errors, "Auteur déjà existant");
            }
    }
    // S'il n'y a pas d'erreur en insert dans la DB
    if (count($errors) == 0) {
        $sql = "INSERT INTO Writers (first_name, last_name, gender) VALUES('$firstname', '$lastname', '$gender')";
        $result = mysqli_query($db,$sql);
    }
}

//Modifier un auteur
    if (isset($_POST['modifyWriter'])) {
        $firstnameWriter = $_POST['firstnameWriter'];
        $lastnameWriter = $_POST['lastnameWriter'];
        $genderWriter = $_POST['genderWriter'];
        $id = $_POST['IDWriter'];
        $sql = "UPDATE Writers SET first_name = '$firstnameWriter', last_name = '$lastnameWriter', gender = '$genderWriter' WHERE ID = $id";
        $result = mysqli_query($db,$sql);
    }

//REQUETE DE SUPPRESSION AUTEUR
if (isset($_POST['deleteWriter'])){
    // Valeurs reçus du post
    $id = $_POST['IDWriter'];
    $sql = "DELETE FROM Writers WHERE ID=$id";
    $result = mysqli_query($db,$sql);
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////// CATEGORIES /////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Ajout d'une catégorie dans la DB
if (isset($_POST['categories'])){
    // Valeurs reçus du post
    $name = mysqli_real_escape_string($db, $_POST['name']);
    $description = mysqli_real_escape_string($db, $_POST['description']);
    // On verifie si c'est pas vide
    if (empty($description)) { array_push($errors, "Déscription requis"); }
    if (empty($name)) { array_push($errors, "Nom requis"); }
     // On verifie que la catégorie n'est pas déjà present dans la DB
    $categories_check_query = "SELECT * FROM Categories WHERE name='$name'";
    $result = mysqli_query($db, $categories_check_query);
    $categories = mysqli_fetch_assoc($result);
    if ($categories) {// si le categories existe
        if ($categories['name'] === $name) {
            array_push($errors, "Catégorie déjà existante");
            }
    }
    // S'il n'y a pas d'erreur en insert dans la DB
    if (count($errors) == 0) {
        $sql = "INSERT INTO Categories (name, description) VALUES('$name', '$description')";
        $result = mysqli_query($db,$sql);
    }
}

//Modifier une categorie
if (isset($_POST['modifyCat'])) {
    $id = $_POST['IDCat'];
    $nameCat = $_POST['nameCat'];
    $descriptionCat = $_POST['descriptionCat'];
    $sql = "UPDATE Categories SET name = '$nameCat', description = '$descriptionCat' WHERE ID = $id";
    mysqli_query($db,$sql);
}

//REQUETE DE SUPPRESSION CATEGORIES
if (isset($_POST['deleteCat'])){
    // Valeurs reçus du post
    $id = $_POST['IDCat'];
    $sql = "DELETE FROM Categories WHERE ID=$id";
    $result = mysqli_query($db,$sql);
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////// SERIES ///////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Ajout d'une série dans la DB
if (isset($_POST['series'])){
    // Valeurs reçus du post
    $nameSeries = mysqli_real_escape_string($db, $_POST['nameSeries']);
    $startingdate = mysqli_real_escape_string($db, $_POST['startingdate']);
    $endingdate = mysqli_real_escape_string($db, $_POST['endingdate']);
    // On verifie si c'est pas vide
    if (empty($nameSeries)) { array_push($errors, "Nom requis"); }
    if (empty($startingdate)) { array_push($errors, "Date de début requis"); }
     // On verifie que la catégorie n'est pas déjà present dans la DB
    $series_check_query = "SELECT * FROM Series WHERE name='$nameSeries'";
    $result = mysqli_query($db, $series_check_query);
    $series = mysqli_fetch_assoc($result);
    if ($series) {// si le series existe
        if ($series['name'] === $nameSeries) {
            array_push($errors, "Serie déjà existante");
            }
    }
    // S'il n'y a pas d'erreur en insert dans la DB
    if (count($errors) == 0) {
        if (empty($endingdate)) 
        { 
            $sql = "INSERT INTO Series (name, starting_date) VALUES('$nameSeries', '$startingdate')";
        } else {
            $sql = "INSERT INTO Series (name, starting_date, ending_date) VALUES('$nameSeries', '$startingdate', '$endingdate')";
        }
        $result = mysqli_query($db,$sql);
    }
}

//Modifier une série
if (isset($_POST['modifySeries'])) {
    $id = $_POST['IDSeries'];
    $nameSeries = $_POST['nameSeries'];
    $startingdate = $_POST['startingdate'];
    $endingdate = $_POST['endingdate'];
    if (empty($endingdate)) 
    { 
        $sql = "UPDATE Series SET name = '$nameSeries', starting_date = '$startingdate', ending_date = NULL WHERE ID = $id";
    } else {
        $sql = "UPDATE Series SET name = '$nameSeries', starting_date = '$startingdate', ending_date = '$endingdate' WHERE ID = $id";
    }
    $result = mysqli_query($db,$sql);
}

//REQUETE DE SUPPRESSION SERIES
if (isset($_POST['deleteSeries'])){
    // Valeurs reçus du post
    $id = $_POST['IDSeries'];
    $sql = "DELETE FROM Series WHERE ID=$id";
    $result = mysqli_query($db,$sql);
    $sql = "UPDATE Books SET ID_Series = NULL WHERE ID_Series = $id";   
    $result = mysqli_query($db,$sql);
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////// OUVRAGES //////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Ajout d'un ouvrage dans la DB 
if (isset($_POST['addBooks'])){
    // Valeurs reçus du post
    $title = mysqli_real_escape_string($db, $_POST['title']);
    $idCategories = mysqli_real_escape_string($db, $_POST['idCategories']);
    $releasing_year = mysqli_real_escape_string($db, $_POST['releasing_year']);
    $numberBook = mysqli_real_escape_string($db, $_POST['numberBook']);
    $description = mysqli_real_escape_string($db, $_POST['description']);
    $idWriter = mysqli_real_escape_string($db, $_POST['idWriter']);
    $url = mysqli_real_escape_string($db, $_POST['img']);
    if (isset($_POST['idSerie'])){
        $idSerie = mysqli_real_escape_string($db, $_POST['idSerie']);
    }

    // On verifie si c'est pas vide
    if (empty($title)) { array_push($errors, "Titre requis"); }
    if (empty($idCategories)) { array_push($errors, "Catégories requise"); }
    if (empty($releasing_year)) { array_push($errors, "Année de publication requise"); }
    if (empty($description)) { array_push($errors, "Description requise"); }
    if (empty($idWriter)) { array_push($errors, "Auteur requis"); }
    if (empty($numberBook)) { array_push($errors, "Nombre de livre requis"); }

     // On verifie que la catégorie n'est pas déjà present dans la DB
    $books_check_query = "SELECT * FROM Books WHERE title='$title' AND ID_Writers='$idWriter'";
    $result = mysqli_query($db, $books_check_query);
    $books = mysqli_fetch_assoc($result);
    if ($books) {// si le livre existe
        if ($books['title'] === $title && $books['ID_Writers'] === $idWriter) {
            array_push($errors, "Livre déjà existante");
            }
    }
    // S'il n'y a pas d'erreur en insert dans la DB
    if (count($errors) == 0) {
        if (isset($_POST['idSerie'])){
            $sql = "INSERT INTO Books (title, ID_Categories	, releasing_year, description, ID_Writers, ID_Series, img, copies_number) VALUES('$title', $idCategories, '$releasing_year', '$description', $idWriter, $idSerie, '$url', $numberBook)";
        }else {
            $sql = "INSERT INTO Books (title, ID_Categories	, releasing_year, description, ID_Writers, img, copies_number) VALUES('$title', $idCategories, '$releasing_year', '$description', $idWriter, '$url', $numberBook)";
        }
        $result = mysqli_query($db,$sql);
        $sql2 = "SELECT ID FROM Books WHERE title='$title'";
        $result2 = mysqli_query($db,$sql2);
        while ($ligne=mysqli_fetch_array($result2)){
            $IDBooks = $ligne['ID'];
            $sql3 = "INSERT INTO Stocks (ID_Books, amount) VALUES($IDBooks, $numberBook)";
        }
        $result = mysqli_query($db,$sql3);
    }  
}

//Modifier un ouvrage
if (isset($_POST['modifyBook'])) {
    $title = $_POST['title'];
    $categories = mysqli_real_escape_string($db, $_POST['Categories']);
    $releasing_year = mysqli_real_escape_string($db, $_POST['releasing_year']);
    $NbBooks = mysqli_real_escape_string($db, $_POST['NbBooks']);
    $description = mysqli_real_escape_string($db, $_POST['description']);
    $url = mysqli_real_escape_string($db, $_POST['url']);
    $IDWriter = mysqli_real_escape_string($db, $_POST['IDWriter']);
    $IDBook = mysqli_real_escape_string($db, $_POST['IDBook']);
    $IDSerie = mysqli_real_escape_string($db, $_POST['IDSerie']);
    $sql = "UPDATE Books SET title='$title', ID_Categories='$categories', releasing_year='$releasing_year', description='$description', ID_Writers=$IDWriter, ID_Series=$IDSerie, copies_number=$NbBooks, img='$url' WHERE ID=$IDBook";
    mysqli_query($db,$sql);
}

//REQUETE DE SUPPRESSION OUVRAGE
if (isset($_POST['deleteBook'])){
    // Valeurs reçus du post
    $IDBook = mysqli_real_escape_string($db, $_POST['IDBook']);
    $sql = "DELETE FROM Books WHERE ID=$IDBook";
    $result = mysqli_query($db,$sql);
    $sql = "DELETE FROM Stocks WHERE ID=$IDBook";
    $result = mysqli_query($db,$sql);
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////// ABONNEMENTS /////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Ajout d'un abonnement dans la DB
if (isset($_POST['subscription'])){
    // Valeurs reçus du post
    $name = mysqli_real_escape_string($db, $_POST['name']);
    $book_amount = mysqli_real_escape_string($db, $_POST['book_amount']);
    $subscriptions_time = mysqli_real_escape_string($db, $_POST['subscriptions_time']);
    $leasing_duration = mysqli_real_escape_string($db, $_POST['leasing_time']);
    $price = mysqli_real_escape_string($db, $_POST['price']);
    $book_cost = mysqli_real_escape_string($db, $_POST['book_cost']);
    // On verifie si c'est pas vide
    if (empty($name)) { array_push($errors, "Nom requis"); }
    if (empty($book_amount)) { array_push($errors, "Nombre de livre empreintable requis"); }
    if (empty($subscriptions_time)) { array_push($errors, "Durée de l'abonnement requis"); }
    if (empty($leasing_duration)) { array_push($errors, "Durée de l'empreint requis"); }
    if (empty($book_cost)) { array_push($errors, "Coût de l'empreint requis"); }


     // On verifie que la catégorie n'est pas déjà present dans la DB
    $subscriptions_check_query = "SELECT * FROM Subscriptions WHERE name='$name'";
    $result = mysqli_query($db, $subscriptions_check_query);
    $subscriptions = mysqli_fetch_assoc($result);
    if ($subscriptions) {// si le subscriptions existe
        if ($subscriptions['name'] === $name) {
            array_push($errors, "Abonnment déjà existante");
            }
    }
    // S'il n'y a pas d'erreur en insert dans la DB
    if (count($errors) == 0) {
        if (empty($price)) 
        { 
            $sql = "INSERT INTO Subscriptions (name, book_amount, subscriptions_time, leasing_duration, book_cost) VALUES('$name', $book_amount, $subscriptions_time, $leasing_duration, $book_cost)";
        } else {
            $sql = "INSERT INTO Subscriptions (name, book_amount, subscriptions_time, leasing_duration, subscription_cost, book_cost) VALUES('$name', $book_amount, $subscriptions_time, $leasing_duration, $price, $book_cost)";
        }
        $result = mysqli_query($db,$sql);
    }
}

//Modifier un abonnement
if (isset($_POST['modifySubscriptions'])) {
    $id = $_POST['IDSubscription'];
    $name = mysqli_real_escape_string($db, $_POST['name']);
    $book_amount = mysqli_real_escape_string($db, $_POST['book_amount']);
    $subscriptions_time = mysqli_real_escape_string($db, $_POST['subscriptions_time']);
    $leasing_duration = mysqli_real_escape_string($db, $_POST['leasing_time']);
    $price = mysqli_real_escape_string($db, $_POST['price']);
    $book_cost = mysqli_real_escape_string($db, $_POST['book_cost']);
   // On verifie si pas d'erreurs et on envoi
    if (count($errors) == 0) {
        if (empty($price)) 
        { 
            $sql = "UPDATE Subscriptions SET name = '$name', book_amount = $book_amount, subscriptions_time = $subscriptions_time, leasing_duration = $leasing_duration, book_cost = $book_cost WHERE ID = $id";
        } else {
            $sql = "UPDATE Subscriptions SET name = '$name', book_amount = $book_amount, subscriptions_time = $subscriptions_time, leasing_duration = $leasing_duration, subscription_cost = $price, book_cost = $book_cost WHERE ID = $id";
        }
        
    $result = mysqli_query($db,$sql);    
    }
}

//REQUETE DE SUPPRESSION ABONNEMENT
if (isset($_POST['deleteSubscriptions'])){
    // Valeurs reçus du post
    $id = $_POST['IDSubscription'];
    $sql = "DELETE FROM Subscriptions WHERE ID=$id";
    $result = mysqli_query($db,$sql);
}




////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////// RESERVATION DE LIVRES ////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////

if (isset($_POST['toBook'])){

    $userID = $_POST['userID'];
    $bookID = $_POST['bookID'];
    $leasingDate = $_POST['leasing_date'];
    $startingDate = $_POST['starting_date'];
    if (isset($_POST['toBookAdmin'])){ 
        $leasingWay = "SHOP";
    } else {
        $leasingWay = "WEB";
    }
    $sql ="SELECT 
        (SELECT ID FROM Subscriptions WHERE ID = Users.ID_Subscriptions) AS ID, 
        (SELECT name FROM Subscriptions WHERE ID = Users.ID_Subscriptions) AS Name, 
        (SELECT leasing_duration FROM Subscriptions WHERE ID = Users.ID_Subscriptions) AS Leasing_duration, 
        (SELECT book_amount FROM Subscriptions WHERE ID = Users.ID_Subscriptions) AS book_amount,
        (SELECT book_cost FROM Subscriptions WHERE ID = Users.ID_Subscriptions) AS book_cost,
        number_leasing
    FROM Users 
    WHERE ID=$userID";
    $result = mysqli_query($db, $sql);
    $subscriptions = mysqli_fetch_assoc($result);
    if ($subscriptions['ID']==1){
        for($i=0; $i<=4; $i++){
            if ( intval($subscriptions['number_leasing'])<($i+1)*10 && intval($subscriptions['number_leasing'])>=$i*10){
                $reduction = $i*10;
                break;
            } 
        }
        if (!isset($reduction)){
            $reduction=50;
        }
        $totalcost = floatval($subscriptions['book_cost'])*(1-($reduction/100));
    } else {
        $totalcost = floatval($subscriptions['book_cost']);
    }

    if (empty($startingDate)) { array_push($errors, "Date requise"); 
    } else {
        $endingDate= date('Y-m-d', strtotime($startingDate. ' + '.$subscriptions['Leasing_duration'].' days'));
    }
    if (count($errors) == 0) {
        // ajout de la reservation a la DB
        $subscriptionId = $subscriptions['ID'];
        if (isset($reduction)){
            $sql = "INSERT INTO Leasing (ID_Users, ID_Books, start_date, end_date, leasing_date, ID_Subscriptions, leasing_cost, leasing_way, discount) VALUES($userID, $bookID, '$startingDate', '$endingDate', '$leasingDate', $subscriptionId, $totalcost, '$leasingWay', $reduction)";
        }else {
            $sql = "INSERT INTO Leasing (ID_Users, ID_Books, start_date, end_date, leasing_date, ID_Subscriptions, leasing_cost, leasing_way) VALUES($userID, $bookID, '$startingDate', '$endingDate', '$leasingDate', $subscriptionId, $totalcost, '$leasingWay')";
        }
        $result = mysqli_query($db,$sql);



        // retrait de un exemplaire au stock
        $sql = "SELECT ID_Books, amount FROM Stocks";
	    $result2 = mysqli_query($db, $sql);
	    while ($ligne=mysqli_fetch_array($result2)){
            $stocks[$ligne['ID_Books']] = $ligne['amount'];
        }
        $newAmount = $stocks[$bookID]-1;
        $sql = "UPDATE Stocks
                SET amount = $newAmount
                WHERE ID_Books = $bookID";
        $result = mysqli_query($db, $sql);

        // ajout de un au compteur de reservation simultané
        $sql = "SELECT leasing_together FROM Users WHERE ID=$userID";
	    $result3 = mysqli_query($db, $sql);
        $leasingTogether = mysqli_fetch_assoc($result3);
        foreach ($leasingTogether as $key => $value){
            $newLeasingTogether = intval($value)+1;
        }
        $sql = "UPDATE Users
                SET leasing_together = $newLeasingTogether
                WHERE ID = $userID";
        $result = mysqli_query($db, $sql);

        // ajout de un au compteur de reservation du user
        $sql = "SELECT number_leasing FROM Users WHERE ID=$userID";
        $result4 = mysqli_query($db, $sql);
        while ($ligne=mysqli_fetch_array($result4)){
            $numberLeasing = $ligne['number_leasing'];
            }
        $newNumberLeasing = intval($numberLeasing)+1;
        $sql = "UPDATE Users
                SET number_leasing = $newNumberLeasing
                WHERE ID = $userID";
        $result = mysqli_query($db, $sql);

        if (isset($_POST['toBookAdmin'])){ 
            header ('location:leasings.php');
        }else {
            header ('location:historical.php');
        }
    }  
}

// Modifier le status 
if (isset($_POST['modifyLeasing'])) {
   
    $id = mysqli_real_escape_string($db, $_POST['ID']);
    $statusId = mysqli_real_escape_string($db, $_POST['ID_Status']);
    $bookID = $_POST['ID_Books'];
    $userID = $_POST['ID_Users'];
    $sql = "SELECT ID FROM Leasing WHERE ID=$id";
    $result = mysqli_query($db,$sql);
    $leasingTogether = mysqli_fetch_assoc($result);

    
    // On verifie si pas d'erreurs et on envoi
    if (count($errors) == 0) {
        if ($statusId == 3){
            //Ajout de un au stock
            $sql = "SELECT ID_Books, amount FROM Stocks";
            $result2 = mysqli_query($db, $sql);
            while ($ligne=mysqli_fetch_array($result2)){
                $stocks[$ligne['ID_Books']] = $ligne['amount'];
            }
            $newAmount = $stocks[$bookID]+1;
            $sql2 = "UPDATE Stocks
                    SET amount = $newAmount
                    WHERE ID_Books = $bookID";
            $result = mysqli_query($db,$sql2);

            // Retrait de un au compteur de location simultané
            $sql = "SELECT leasing_together FROM Users WHERE ID=$userID";
            $result = mysqli_query($db, $sql);
            $leasingTogether = mysqli_fetch_assoc($result);
            foreach ($leasingTogether as $key => $value){
                $newLeasingTogether = intval($value)-1;
            }
            $sql = "UPDATE Users
                    SET leasing_together = $newLeasingTogether
                    WHERE ID = $userID";
            $result = mysqli_query($db, $sql);
        }

        $sql = "UPDATE Leasing SET ID_Status = $statusId WHERE ID = $id";   
        $result = mysqli_query($db,$sql);    
    }
}

//REQUETE DE SUPPRESSION RESERVATION
if (isset($_POST['deleteLeasing'])){
    // Valeurs reçus du post
    $id = $_POST['ID'];
    $sql = "DELETE FROM Leasing WHERE ID=$id";
    $result = mysqli_query($db,$sql);
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////// FORMULAIRE DE CONTACT ////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////

if (isset($_POST['mail'])){
    if(isset( $_POST['name']))
    $name = $_POST['name'];
    if(isset( $_POST['email']))
    $email = $_POST['email'];
    if(isset( $_POST['message']))
    $message = $_POST['message'];
    if(isset( $_POST['subject']))
    $subject = $_POST['subject'];

    $content="De: $name \n Email: $email \n Message: $message";
    $recipient = "jeremyb86@alwaysdata.net";
    $mailheader = "De: $email \r\n";
    mail($recipient, $subject, $content, $mailheader) or die("Error!");
}