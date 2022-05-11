<?php
include 'inc/header.php';
Session::CheckSession();
 ?>
 <?php

 if (isset($_GET['id'])) {
   $userid = (int)$_GET['id'];

 }

//Renvoie vers la fonction pour update la table avec les informations saisie 
 if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['changepass'])) {
    $changePass = $users->changePasswordBysingelUserId($userid, $_POST);
 }


 if (isset( $changePass)) {
   echo  $changePass;
 }
  ?>

<!--Formulaire de changement de mot de passe -->
 <div class="card ">
   <div class="card-header">
          <h3>Changer de Mot de passe <span class="float-right"> <a href="profile.php?id=<?php  ?>" class="btn btn-primary">Retour</a> </h3>
        </div>
        <div class="card-body">

          <div style="width:600px; margin:0px auto">

          <form class="" action="" method="POST">
              <div class="form-group">
                <label for="old_password">Mot de passe Actuel</label>
                <input type="password" name="old_password"  class="form-control">
              </div>
              <div class="form-group">
                <label for="new_password">Nouveau Mot de passe</label>
                <input type="password" name="new_password"  class="form-control">
              </div>
              <div class="form-group">
                <button type="submit" name="changepass" class="btn btn-success">Mettre à jour</button>
              </div>

          </form>
        </div>

      </div>
    </div>

  <?php
  include 'inc/footer.php';

  ?>
