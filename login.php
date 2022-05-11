<?php
include 'inc/header.php';
Session::CheckLogin();
?>

<!--Si utilisateur clique sur connexion vérification dans la table -->
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
   $userLog = $users->userLoginAuthotication($_POST);
}
if (isset($userLog)) {
  echo $userLog;
}
//Si impossible alors déconnexion 
$logout = Session::get('logout');
if (isset($logout)) {
  echo $logout;
}

?>

<!--Formulaire de connexion -->


<div class="card ">
  <div class="card-header">
          <h3 class='text-center'><i class="fas fa-sign-in-alt mr-2"></i>Se connecter</h3>
        </div>
        <div class="card-body">
            <div style="width:450px; margin:0px auto">

            <form class="" action="" method="post">
                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" name="email"  class="form-control">
                </div>
                <div class="form-group">
                  <label for="password">Mot de passe</label>
                  <input type="password" name="password"  class="form-control">
                </div>
                <div class="form-group">
                  <button type="submit" name="login" class="btn btn-success">Connexion</button>
                  <a class="btn btn-primary" href="register.php" role="button">Inscription</a>
                  <a class="btn btn-info" href="postuler.php" role="button">Devenir Instructeur</a>
                </div>
                
            </form>
              
          </div>

        </div>
      </div>
  <?php
  include 'inc/footer.php';

  ?>
