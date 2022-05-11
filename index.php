<?php
include 'inc/header.php';

Session::CheckSession();

//Message indication de réussite ou échec 
$logMsg = Session::get('logMsg');
if (isset($logMsg)) {
  echo $logMsg;
}
$msg = Session::get('msg');
if (isset($msg)) {
  echo $msg;
}
Session::set("msg", NULL);
Session::set("logMsg", NULL);
?>

<!--Méthode pour faire des actions supprimer, dsactiver profil de façon dynamique-->
<?php

if (isset($_GET['remove'])) {
  $remove = preg_replace('/[^a-zA-Z0-9-]/', '', (int)$_GET['remove']);
  $removeUser = $users->deleteUserById($remove);
}

if (isset($removeUser)) {
  echo $removeUser;
}
if (isset($_GET['deactive'])) {
  $deactive = preg_replace('/[^a-zA-Z0-9-]/', '', (int)$_GET['deactive']);
  $deactiveId = $users->userDeactiveByAdmin($deactive);
}

if (isset($deactiveId)) {
  echo $deactiveId;
}
if (isset($_GET['active'])) {
  $active = preg_replace('/[^a-zA-Z0-9-]/', '', (int)$_GET['active']);
  $activeId = $users->userActiveByAdmin($active);
}

if (isset($activeId)) {
  echo $activeId;
}
 ?>

      <div class="card ">
        <div class="card-header">
          <h3><i class="fas fa-users mr-2"></i> Utilisateurs Actifs<span class="float-right">Bienvenue <strong>
            <span class="badge badge-lg badge-secondary text-white">

  <!--Nom de l'utilisateur connecter-->
<?php
$username = Session::get('username');
if (isset($username)) {
  echo $username;
}
 ?></span>

          </strong></span></h3>
        </div>
        <!--Tableau de gestion des utilisateurs -->
        <div class="card-body pr-2 pl-2">
          <table id="example" class="table-striped table-bordered" style="width:100%">
                  <thead>
                    <tr>
                      <th  class="text-center">Pseudo</th>
                      <th  class="text-center">@Email</th>
                      <th  class="text-center">Status</th>
                      <th  class="text-center">Crée le</th>
                      <th  width='25%' class="text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <!--Affichage des utilisateurs dans le tableau avec un foreach -->
                    <?php
                      $allUser = $users->selectAllUserData();

                      if ($allUser) {
                        $i = 0;
                        foreach ($allUser as  $value) {
                          $i++;

                     ?>
                      <!--Affiche ligne bleu pour identifier qui est connecter avec la session en cours dans le tableau de gestion-->
                      <tr class="text-center"
                      <?php if (Session::get("id") == $value->id) {
                        echo "style='background:#d9edf7' ";
                      } ?>
                      >

                          <!--Couleurs distinc pour les roles des utilisateurs-->
                        <td><?php echo $value->username; ?> <br>
                          <?php if ($value->roleid  == '1'){
                          echo "<span class='badge badge-lg badge-info text-white'>Administrateur</span>";
                        } elseif ($value->roleid == '2') {
                          echo "<span class='badge badge-lg badge-dark text-white'>Instructeur</span>";
                        }elseif ($value->roleid == '3') {
                            echo "<span class='badge badge-lg badge-dark text-white'>Apprenant</span>";
                        } ?></td>
                        <td><?php echo $value->email; ?></td>

             
                        <td><!--Active / desactive les compte affichage du status-->
                          <?php if ($value->isActive == '0') { ?>
                          <span class="badge badge-lg badge-info text-white">Activé</span>
                        <?php }else{ ?>
                    <span class="badge badge-lg badge-danger text-white">Désactivé</span>
                        <?php } ?>
                              <!--Affiche les date de création de compte des utilisateurs-->
                        </td>
                        <td><span class="badge badge-lg badge-secondary text-white"><?php echo $users->formatDate($value->created_at);  ?></span></td>

                        <td>

                        <!--Si session = apprenant alors redirection vers nouveau tableau de bord -->
                        <?php if( Session::get("roleid") == '3'){ ?>
                          <script>
                                   window.location.replace("suivie.php")</script>
                          <?php } ?>

                        <!--Si session = instructeur alors redirection vers nouveau tableau de bord -->
                          <?php if( Session::get("roleid") == '2'){ ?>
                            <!-- Redirection --->
                          <script>window.location.replace("formations.php")</script>
                       <?php } ?>


                          <!--Tableau de gestion admin modifier supprimer desactiver un compte -->
                        <?php if ( Session::get("roleid") == '1') {?>

                            <a class="btn btn-info btn-sm " href="profile.php?id=<?php echo $value->id;?>">Modifier</a>
       
                            <a onclick="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?')" class="btn btn-danger
                            <?php if (Session::get("id") == $value->id) {
                              echo "disabled";
                            } ?>
                             btn-sm "  href="?remove=<?php echo $value->id;?>">Suppimer</a>

                             <?php if ($value->isActive == '0') {  ?>
                               <a onclick="return confirm(' Voulez-vous vraiment désactiver cet utilisateur ?')" class="btn btn-warning
                                <?php if (Session::get("id") == $value->id) {
                                  echo "disabled";
                                } ?>
                                btn-sm " href="?deactive=<?php echo $value->id;?>">Désactiver</a>


                             <?php } elseif($value->isActive == '1'){?>
                               <a onclick="return confirm('Voulez-vous vraiment réactiver cet utiisateur ?')" class="btn btn-secondary
                                  <?php if (Session::get("id") == $value->id) {
                                    echo "disabled";
                                  } ?>
                                btn-sm " href="?active=<?php echo $value->id;?>">Réactiver</a>
                             <?php } ?>
                          <?php  
                          }
                        }
                        ?>          
                        <?php }if( Session::get("roleid") == ''){ ?>
                      <tr class="text-center">
                      <td>Connexion Impossible <br> Erreur 404 !</td>
                    </tr>
                    <?php }
                   ?>

                  </tbody>

              </table>
        </div>
        </div>
      </div>

  <?php
  include 'inc/footer.php';

  ?>