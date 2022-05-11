<?php
include 'inc/header.php';
if(!isset($_GET["formid"])){
        header('Location:index.php');
}
include "get_bdd.php";
if(isset($_POST["id"])){
    //Méthode pour valider une leçon si elle est terminé 
    $bdd->prepare("insert into validatedlecons ( LeconId , UserId) VALUES (".$_POST["id"].",".Session::get('id').")")->execute();
}
//Recherche dans la table section tout les id des formations
foreach($bdd->query("SELECT * from section where formationID =".$_GET["formid"])->fetchAll() as $section){
    ?>

<div class="card ">
   <div class="card-header">
          <h3  class='text-center'>Suivre une formation</h3>
        </div>
        <div class="card-body">

        <!--Tableau des données -->
    <table  id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <th>
                <tr>
                    <td>Nom de la leçon</td>
                    <td>Desctiption de la section</td>
                    <td>Vidéo</td> 
                    <td>Documents</td> 
                    <td>Terminer la leçon</td> 
                </tr>
            </th>
        </thead>
        <tbody>
        <?php
        foreach($bdd->query("SELECT * from lecon where sectionId =".$section["id"])->fetchAll() as $lecon){
            ?>
            <tr>
                <td><?php echo $lecon["Nom"] ?></td>
                <td><?php echo $lecon["Description"] ?></td>
                <td><video style="max-width:300px;" src='<?php echo $lecon["VideoPath"] ?>' controls></td>
                <td>
                    <ul>
                        <?php
                        //recherche dans table lecondocs les id des lecons correspondant 
                        foreach($bdd->query("select * from lecondocs where leconId =".$lecon["id"])->fetchAll() as $docs){
                            ?>
                            <li>
                                <!--Téléchargement des doc-->
                                <a download href="<?php echo $docs["DocPath"] ?>" >Télecharger <?php echo $docs["DocName"] ?></a>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </td>
                <!--Actione le status de la leçon celon l'id de l'utilisateur-->
                <?php
                $sql = "SELECT UserId,LeconId from validatedlecons where UserId =".Session::get('id')." and LeconId = ".$lecon["id"];
                $id = $bdd->query($sql)->fetchAll();
                if($id[0]["UserId"] != Session::get('id') || $id[0]["LeconId"] != $lecon["id"]){
                    ?>
                    <td>
                    <form method="post" action="#">
                        <input type="hidden" name="id" value="<?php echo $lecon["id"] ?>">
                        <button type="submit" class="btn btn-info">Terminer la leçon</button>
                    </form>
                </td><?php 
                }else{
                    ?>
                    <td> <?php echo '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong>Leçon Terminé </strong></div>';
                        ?></td>
                    <?php
                }
                ?>              
            <?php  
            
                ?>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
<?php
}
include 'inc/footer.php';
?>