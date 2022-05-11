<?php
include 'inc/header.php';
 ?>
<?php
//Si champs bien rempli alors role de nouvel utilisateur = instructeur
  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addUser'])) {
  
    $userAdd = $users->addNewUserByAdmin($_POST);
  }

?>

<!--Formulaire d'inscription-->
<div class="card ">
   <div class="card-header">
          <h3 class='text-center'>Inscrire un instructeur</h3>
        </div>
        <div class="cad-body">

            <div style="width:600px; margin:0px auto">

            <form class="" action="" method="post">
                <div class="form-group">
                  <label for="prenom">Pseudo</label>
                  <input type="text" name="username" class="form-control">
                </div>
                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" name="email" class="form-control">
                </div>
                <div class="form-group">
                  <label for="password">Mot de passe</label>
                  <input type="password" name="password" class="form-control">
                </div>
                <div class="form-group">
                  <div class="form-group">
                    <label for="sel1">Rôle de l'utilisateur</label>
                    <select class="form-control" name="roleid" id="roleid">
                      <option value="2">Instructeur</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <button type="submit" name="addUser" class="btn btn-success">Valider</button>
                </div>


            </form>
          </div>


        </div>
      </div>
