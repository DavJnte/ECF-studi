<?php
include 'inc/header.php';
Session::CheckSession();
$sId =  Session::get('roleid');

//Si boutton supprimer alors fonction delete active dans classes/user.php fonction deletedemande
if (isset($_GET['remove'])) {
  $removed = preg_replace('/[^a-zA-Z0-9-]/', '', (int)$_GET['remove']);
  $removeUser = $users->deletedemande($removed);
}
if (isset($removeUser)) {
  echo $removeUser;
}
if ($sId === '1') { ?>

<!--Tableau des demande de mise en attente -->
<div class="card ">
   <div class="card-header">
          <h3 class='text-center'>Demande mise en attente</h3>
        </div>
        <div class="cad-body">
<table id="example"class="table-striped table-bordered" style="width:100%">
                  <thead>
                    <tr>
                      <th  class="text-center">Nom</th>
                      <th  class="text-center">Prenom</th>
                      <th  class="text-center">@email</th>
                      <th  class="text-center">specialité</th>
                      <th  class="text-center">mot de passe</th>
                      <th  class="text-center">Photo de profil</th>
                      <th  class="text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <div class="card-body pr-2 pl-2">

        <tr class="text-center">    
          <?php
          //connexion à la bdd pour afficher dans le tableau les demandes en cours de validation
              
              $bdd= new PDO("mysql:host=localhost;dbname=db_ecoit;charset=utf8", "root", "root");
              $reponse = $bdd->query('SELECT * FROM demande');
              $alldedmande = $reponse;

              if ($alldedmande){
                $i=0;
              }
              foreach ($alldedmande as $value )
              {
                $i++;
                ?>
                <td><?php echo $value['nom'] ?></td>
                      <td><?php  echo $value['prenom'] ?></td>

                      <td><?php echo $value['email'] ?></td>

                      <td><?php  echo $value['specialite']?></td>

                      <td><?php  echo $value['mdp'] ?></td>

                      <td> <?php echo $value['image'] ?></td>

                       <!--Si admin accepte alors redirige vers le formulaire pour inscrire le candidat en tant que instructeur-->
                      <td> <a class="btn btn-success btn-sm " href="./formulaire.php?id">Accepter</a>
                      <a onclick="return confirm('Voulez-vous vraiment supprimer cette demande ?')" class="btn btn-danger
                            <?php if (Session::get("id") == $value->id) {
                              echo "disabled";
                            } ?>
                             btn-sm " href="?remove=<?= $value['id']?>">Suppimer</a>
                            </td>
                    <tr>
              <?php
              }
           ?>                
            </tr>
        
        </tbody>
    </table>
</div>
</div>
                               
<?php
}else{
  header('Location:index.php');
}
 ?>

  <?php
  include 'inc/footer.php';
  ?>



                        