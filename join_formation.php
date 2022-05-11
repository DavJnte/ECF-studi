<?php
include 'inc/header.php';
Session::CheckSession();
include 'get_bdd.php';
if(isset($_POST["id"])){
    $sql = "INSERT INTO userformations (FormationId,UserId) VALUES(".$_POST["id"].",".Session::get('id').")";
    $t = $bdd->prepare($sql);
    $r = $t->execute();
    if ($r){
        echo '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Formation Ajouté à votre liste!</strong></div>';
    }
}   
?>

<div class="card ">
   <div class="card-header">
          <h3  class='text-center'>Rejoindre une formation </h3>
        </div>
        <div class="cad-body">         
<table id="example" class="table table-striped table-bordered" style="width:100%">
    <thead>
        <tr>
        <th>Nom formation</th>
        <th>Rejoindre formation</th>
        </tr>
    </thead>
    <tbody>
        <?php

        $fs = $bdd->query("SELECT titre,id from formations"); 
        foreach($fs as $formation){
            ?>
                <?php
                $userforms = $bdd->query("SELECT FormationId from userformations")->fetchAll();
                $check = true;
                foreach($userforms as $forms){
                    if($userforms["FormationId"] != $formation["id"]  ){
                        $check = true;
                    }
                }
                if($check){
                ?>
                    <tr>
                        <form method="post" action="#">
                        <td><?php echo $formation["titre"] ?></td>
                        <input type='hidden' name='id' value='<?php echo $formation["id"] ?>'>
                        <td><input type="submit" value="Rejoindre"></td>
                    </form> 
                </tr>
                <?php } ?>
            <?php
        }
        ?>
    </tbody>
</table>
        </div>
    </div>
</div>

<?php
include 'inc/footer.php';
?>