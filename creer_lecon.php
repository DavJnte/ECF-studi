<?php
  include 'inc/header.php';
  Session::CheckSession();  
  include 'get_bdd.php';

//Verification du fichier déposer si déjà déposé ou non selon le nom de celui-ci
  $section = $bdd->query("SELECT * FROM section");
  if(isset($_POST["section"]) && !empty($_POST["name"]) && !empty($_POST["description"])){
    $target_dir = "Documents/";
    $target_file = $target_dir . basename($_FILES["video"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    if (file_exists($target_file)) {
      echo'<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>Attention !</strong>Nom de Vidéo déjà utilisé !</div>';
    }
    if (move_uploaded_file($_FILES["video"]["tmp_name"], $target_file)) {
      header("Location:index.php");
    } else {
      echo'<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>Attention !</strong> Erreur de saisie !</div>';
    }

    //insert dans la table lecon la lecon qui à été créer depuis le formulaire
      $sql = "INSERT INTO lecon (SectionId, Nom,Description,Creator,VideoPath,VideoName) 
      VALUES (".$_POST['section'].",'". $_POST['name']."','". $_POST['description']."',".Session::get('id').",'". $target_file."','".$_FILES["video"]["name"]."')";
      $stmt = $bdd->prepare($sql);
      $req = $stmt->execute();    
  };
  
?>

<!--Formulaire de création de leçon -->
<div class="card ">
   <div class="card-header">
          <h3  class='text-center'>Créer une leçon</h3>
        </div>
        <div class="card-body">
            <div style="width:450px; margin:0px auto">
            <form method="post" action="#" enctype="multipart/form-data">
            <div class="form-group">
              <br>
              <label>Nom de la leçon : </label>
              <input type="text" name="name"  class="form-control"></br>

              <label>Video de la leçon : </label>
              <br>
              <input type="file" accept=".mp4" name="video" ></br>
              <br>
              <label>Description de la leçon : </label>
              <textarea name = "description"  class="form-control"></textarea></br>

              <label>Selectionner la section : </label>
              <select id="section" name="section"  class="form-control">
                
              <?php
              //Affiche dans la liste déroulante les sections déjà créer 
                foreach($section as $sec){
                  echo('<option value="'.$sec["id"].'">'.$sec["Nom"].'</option>');
                }
              ?>
              </select>
              <br>
              <button type="submit" class="btn btn-success">Valider</button>
            </div>
          </div>
  </form> 
        </div>
</div>

<?php
  include 'inc/footer.php';
?>

