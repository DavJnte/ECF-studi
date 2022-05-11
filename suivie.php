<?php
include 'inc/header.php';
?>
      <div class="card ">
        <div class="card-header">
          <h3><i class="fas fa-users mr-2"></i>Formation suivies<span class="float-right">Bienvenue<strong>
            <span class="badge badge-lg badge-secondary text-white">
<?php
include 'get_bdd.php';
$username = Session::get('username');
if (isset($username)) {
  echo $username;
}
 ?></span>
 
          </strong></span></h3>
        </div>
        <div class="card-body pr-2 pl-2">
          <table id="example" class="table table-striped table-bordered" style="width:100%">
                  <thead>
                    <tr>
                      <th  class="text-center">Titre</th>
                      <th  class="text-center">Date de Création</th>           
                    </tr>
                  </thead>
                  <tbody>

                  <?php

                  //Affiche dans le tableau avec foreach dans la table formations 
                  $fs = $bdd->query("SELECT * FROM formations");
                  $resultat = $fs->fetchall();
                 
                  if ($resultat) {
                    $i = 0;

                  foreach($resultat as $formation){
                      $i++;
                    ?>
                    <tr>
                      <td><a class="btn btn-warning" href="show_formation.php?formid=<?php echo $formation['id'] ?>"><?php echo $formation["titre"]?></a></td>
                      <td><?php echo $formation["created_at"]?></td>
                                   
                      <?php } ?>
                    </tr>
                    <?php
                  }
                  ?>
                  </tbody>
              </table>
        </div>
      </div>
  <?php
  include 'inc/footer.php';
  ?>
