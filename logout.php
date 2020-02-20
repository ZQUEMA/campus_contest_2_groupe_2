<!-- page qui sert a detruire la variable session, pour que le user (admin ou non) ce deconnecte -->
<?php
    session_start();
    session_destroy();
    // On l'envoie ensuite sur la page index.php
    header('location: index.php');
    exit;
?>