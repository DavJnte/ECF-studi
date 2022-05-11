<?php

include 'inc/header.php';
Session::CheckSession();
$sId =  Session::get('roleid');

//Fonction date du jour
function formatDate($date){
    $strtime = strtotime($date);
  return date('Y-m-d H:i:s', $strtime);
 }

  if(isset($_POST["title"]) && !empty($_POST["title"])){
    $titre = strip_tags(($_POST["title"]));
    //Verif session 
    include 'get_bdd.php';

    //Insert dans la table formation le nom de la formation par id utilisateur
    $sql ="INSERT INTO formations (titre,id_user) VALUES ('".$titre."',".Session::get('id').")";
    $exec =  $bdd->prepare($sql);
    $req = $exec->execute();

    //Si execute alors redirection vers le prochain formulaire 
    header('Location:creer_section.php');

   if(!$req){
        echo'<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Attention !</strong> Erreur de saisie !</div>';
      die("erreur");
   }
  else{
      die();
  }
}
?>

<!--Formulaire Création d'une formation-->
 <div class="card ">
   <div class="card-header">
          <h3  class='text-center'>Créer une formation</h3>
        </div>
        <div class="card-body">
            <div style="width:450px; margin:0px auto">

              <form class="" action="" method="post">
              <br>
                <div class="form-group">
                  <label for="title">Titre Formation :</label>
                  <input type="text" name="title"  class="form-control">
                  <br>
                  <div class="form-group">
                  <button type="submit" name="addUser" class="btn btn-success">Valider</button>
        
                  </div>
                </div>
            </div>
            </form>
         </div>
</div>

  <?php
  include 'inc/footer.php';

  ?>

