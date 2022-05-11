<?php
include 'inc/header.php';
Session::CheckSession();

 ?>

<?php

if (isset($_GET['id'])) {
  $userid = preg_replace('/[^a-zA-Z0-9-]/', '', (int)$_GET['id']);

}
//Update de la table si modification du profile
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
  $updateUser = $users->updateUserByIdInfo($userid, $_POST);

}
if (isset($updateUser)) {
  echo $updateUser;
}

 ?>


 <div class="card ">
   <div class="card-header">
          <h3>Profil utilisateur<span class="float-right"></h3>
        </div>
        <div class="card-body">

    <?php
    $getUinfo = $users->getUserInfoById($userid);
    if ($getUinfo) {
     ?>

          <div class="card-body">
            <div style="width:450px; margin:0px auto">

            <!--Remplissage du form avec donées de l'utiisateur-->
          <form class="" action="" method="POST">
              <div class="form-group">
                <label for="username">Pseudo</label>
                <input type="text" name="username" value="<?php echo $getUinfo->username; ?>" class="form-control table-bordered">
              </div>
              <div class="form-group">
                <label for="email">Adresse Mail</label>
                <input type="email" id="email" name="email" value="<?php echo $getUinfo->email; ?>" class="form-control table-striped">
              </div>

                <!--Si c'est un admin alors droit de changer le role du profil-->
              <?php if (Session::get("roleid") == '1') { ?>

              <div class="form-group
              <?php if (Session::get("roleid") == '1' && Session::get("id") == $getUinfo->id) {
                echo "d-none";
              } ?>
              ">
                <div class="form-group">
                  <label for="sel1">Rôle</label>
                  <select class="form-control" name="roleid" id="roleid">

                  <?php

                if($getUinfo->roleid == '1'){?>
                  <option value="1" selected='selected'>Administrateur</option>
                  <option value="2">Instructeur</option>
                  <option value="3">Apprenant</option>
                <?php }elseif($getUinfo->roleid == '2'){?>
                  <option value="1">Administrateur</option>
                  <option value="2" selected='selected'>Instructeur</option>
                  <option value="3">Apprenant</option>
                <?php }elseif($getUinfo->roleid == '3'){?>
                  <option value="1">Administrateur</option>
                  <option value="2">Instructeur</option>
                  <option value="3" selected='selected'>Apprenant</option>


                <?php } ?>


                  </select>
                </div>
              </div>
                    <!--Si non admin alors modification de profil normal sans privilège -->
          <?php }else{?>
            <input type="hidden" name="roleid" value="<?php echo $getUinfo->roleid; ?>">
          <?php } ?>

              <?php if (Session::get("id") == $getUinfo->id) {?>


              <div class="form-group">
                <button type="submit" name="update" class="btn btn-success">Mettre à jour</button>
                <a class="btn btn-primary" href="changepass.php?id=<?php echo $getUinfo->id;?>">Changer Mot de passe</a>
              </div>
            <?php } elseif(Session::get("roleid") == '1') {?>


              <div class="form-group">
                <button type="submit" name="update" class="btn btn-success">Mettre à jour</button>
                <a class="btn btn-primary" href="changepass.php?id=<?php echo $getUinfo->id;?>">Changer Mot de passe</a>
              </div>
            <?php } elseif(Session::get("roleid") == '2') {?>


              <div class="form-group">
                <button type="submit" name="update" class="btn btn-success">Mettre à jour</button>

              </div>

              <?php   }else{ ?>
                  <div class="form-group">

                    <a class="btn btn-primary" href="index.php">Ok</a>
                  </div>
                <?php } ?>
          </form>
        </div>

      <?php }else{
        //sI echec de MAJ redirection sur le tableau de bord principal
        header('Location:index.php');
      } ?>

      </div>
    </div>

  <?php
  include 'inc/footer.php';
  ?>
