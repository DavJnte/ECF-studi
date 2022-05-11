<?php
include 'inc/header.php';
Session::CheckLogin();
//Si utilisateur rempli les champs alors insert dans la table des utilisateurs 
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {

  $register = $users->userRegistration($_POST);
}

if (isset($register)) {
  echo $register;
}

 ?>
<!--Formulaire de création de compte obligatoirement role apprenant-->
 <div class="card ">
   <div class="card-header">
          <h3 class='text-center'><i class="fas fa-sign-in-alt mr-2"></i>Créer un Compte</h3>
        </div>
        <div class="card-body">
            <div style="width:450px; margin:0px auto">

            <form class="" action="" method="post">
                <br>
                <div class="form-group">
                  <label for="username">Pseudo</label>
                  <input type="text" name="username"  class="form-control">
                </div>
                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" name="email"  class="form-control">
                </div>
                <div class="form-group">
                  <label for="password">Mot de passe</label>
                  <input type="password" name="password" class="form-control">
                  <input type="hidden" name="roleid" value="3" class="form-control">
                </div>
                <div class="form-group">
                  <button type="submit" name="register" class="btn btn-success">Créer un compte</button>
                </div>
            </form>
          </div>


        </div>
      </div>

  <?php
  include 'inc/footer.php';

  ?>
