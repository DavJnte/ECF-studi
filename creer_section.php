<?php
  include 'inc/header.php';
  Session::CheckSession();  
  include 'get_bdd.php';
  $forms = $bdd->query("SELECT * from formations");

  //Insert dans la table section les informations lié avec une formation par id
  if(isset($_POST["formation"]) && !empty($_POST["title"])){
      $sql = "INSERT INTO section (formationID,Nom,Creator) VALUES (".$_POST['formation'].",'". $_POST['name']."','".Session::get('id')."')";
        $stmt = $bdd->prepare($sql);
        $req = $stmt->execute();
        
          //Si execute alors redirection vers le prochain formulaire 
        header('Location:creer_lecon.php');

        //Sinon erreur
        if(!$req){
         echo '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Attention !</strong> Erreur de saisie !</div>';
        die("erreur");
     }
  };
?>

<!--Formualire de création de section-->
<div class="card ">
   <div class="card-header">
          <h3  class='text-center'>Créer une section</h3>
        </div>
        <div class="card-body">
            <div style="width:450px; margin:0px auto">

            <form method="post" action="#">
                  <br>
                <label for="title">Nom de la section : </label>
                <input type="text" name="name"  class="form-control">
                <br>

                <label>Selectionner la Formation : </label>
                <select id="formations" name="formation"  class="form-control">

      <?php
      //Affiche dans la liste déroulante les formation déjà créer 
      foreach($forms as $formation){
        echo('<option value="'.$formation["id"].'">'.$formation["titre"].'</option>');
      }
      ?>
    </select>
    <br>
    <button type="submit" class="btn btn-success">Valider</button>
  </form> 
  <br>
</div>
</div>
</div>
<?php
  include 'inc/footer.php';
?>

