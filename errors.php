<!-- ici on compte le nombre d'erreur -->
<?php  if (count($errors) > 0) : ?>
<div class="error">
<?php foreach ($errors as $error) : ?>
<!-- On affiche le nombre derreur reçus de la page request.php -->
<p><?php echo $error ?></p>
<?php endforeach ?>
</div>
<?php  endif ?>