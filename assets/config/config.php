<?php
// Connexion à la BDD
$db = mysqli_connect('mysql-jeremyb86.alwaysdata.net', 'jeremyb86_campus', 'campus4949!', 'jeremyb86_campuscontest');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>