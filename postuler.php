<?php
include 'inc/header.php';

//Envoie dans la table les info de l'utilisateur 
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['postuler'])) {

    $pos= $users->postuler($_POST); 
}

if (isset($pos)) {
      echo $pos;
}
?>

<!--Formulaire de demande -->
 <div class="card ">
   <div class="card-header">
          <h3 class='text-center'></i>Devenir Instructeur</h3>
        </div>
        <div class="card-body">
            <div style="width:450px; margin:0px auto">
            <br>
            <p>Postuler auprès de l'administrateur pour devenir Instructeur et proposer des formations sur la plateforme !</p>
            <form class="" action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="nom">Nom</label>
                  <input type="text" name="nom"  class="form-control">
                </div>
                <div class="form-group">
                  <label for="prenom">Prenom</label>
                  <input type="text" name="prenom"  class="form-control">
                </div>
                <div class="form-group">
                  <label for="email">@Email</label>
                  <input type="email" name="email"  class="form-control">
                </div>
                <div class="form-group">
                  <label for="specialite">Spécialité</label>
                  <input type="text" name="specialite"  class="form-control">
                </div>
                <div class="form-group">
                  <label for="mdp">Mot de passe</label>
                  <input type="mdp" name="mdp" class="form-control">
                </div>
                <div class="form-group">
                  <label for="photo">Photo de Profil (Facultatif)</label>
                  <br>
                  <input type="file" name="image">
                  <br>
                  <br>
                </div>
                  <input type="submit" name="postuler" value="Postuler" class="btn btn-success"></input>
            </form>
            <br>
          </div>

        </div>
      </div>
<?php
  include 'inc/footer.php';
?>
