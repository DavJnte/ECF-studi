<?php
include 'inc/header.php';
?>

      <div class="card ">
        <div class="card-header">
          <h3><i class="fas fa-users mr-2"></i>Formations<span class="float-right">Bienvenue Instructeur<strong>
            <span class="badge badge-lg badge-secondary text-white">
  <!--Vérification de session-->
<?php
Session::CheckSession();
$username = Session::get('username');
  include 'get_bdd.php';
if (isset($username)) {
  echo $username;
}

//Posibilité d'update les noms des sections et des lecons si erreur de l'instructeur
if( isset($_POST["type"])){
  switch($_POST["type"]){
    case"Section":
      $sql = "UPDATE Section SET Nom = '".$_POST["name1"]."' WHERE id = ".$_POST["id1"];
      break;
    case"Lecon":
      $sql = "UPDATE Lecon SET Nom = '".$_POST["name2"]."' WHERE id = ".$_POST["id2"];
      break;
      default;
  }
  try{
    $stmt = $bdd->prepare($sql);
    $req = $stmt->execute();
  }catch(PDOException $e){
    echo $e->getMessage().'<br/>';
  }
}
$formation ="";
?>

 </span>
    </strong>
  </span>
  </h3>
    </div>
    <!--Tableau des formations par id-->
        <div class="card-body pr-2 pl-2">

          <table id="example" class="table table-striped table-bordered" style="width:100%">
                  <thead>
                    <tr>
                      <th  class="text-center">Titre</th>
                      <th  class="text-center">Date de Création</th>
                      <th  class="text-center">Modifier</th>
                
                    </tr>
                  </thead>
                  <tbody>  
                    <?php
                    //Affiche les formations d'un instructeur par id
                        $reponse = $bdd->query('SELECT * FROM formations where id_user = '.Session::get('id'));
                        while ($donnees1 = $reponse->fetch())
                        {
                          ?>
                          <tr class="text-center">  
                          <td><?php echo $donnees1['titre'] ?></td> <!--Titre de la formation par id-->
                          <td><?php echo $donnees1['created_at'] ?></td><!--Date de création par id-->
                          <td>
                            <form method="post" action="EditFormation.php">
                              <button type="submit" class="btn btn-info">Modifier</button>
                              <input type="hidden" name="FormId" value= <?php echo $donnees1["id"]; ?>>
                            </form>
                          </td>
                        </tr>
                        <?php

                        }
                     ?>           
                  </tbody>
              </table>

      <h3><i class="fas fa-users mr-2"></i>Sections</h3>
      </div>
        <div class="card-body pr-2 pl-2">

          <table id="example" class="table table-striped table-bordered" style="width:100%">
                  <thead>
                    <tr>
                      <th  class="text-center">Nom</th>
                      <th  class="text-center">leçons</th>
                      <th  class="text-center">Modifier</th>
                
                    </tr>
                  </thead>
                  <tbody> 
                    <?php
                      //Affiche les sections d'un instructeur par id
                        $reponse = $bdd->query('SELECT DISTINCT id,Nom FROM section where Creator ='.Session::get('id'));
                        while ($donnees2 = $reponse->fetch())
                        {
                          ?>
                          <tr class="text-center">   
                          <td><?php echo $donnees2['Nom'] ;?></td>
                          <td><ul>
                            <?php
                              $r = $bdd->query('SELECT DISTINCT Nom FROM lecon where SectionId = '.$donnees2["id"]);
                              while ($d = $r->fetch())
                              {?>
                                  <li><?php echo $d["Nom"] ; ?></li>
                              <?php
                              }
                            ?>
                          </ul></td>
                          <td>
                            <form method="post" action="#">
                              <label>Nouveau nom  </label><input type='text' name="name1">
                              <input type='hidden' name="id1" value=<?php echo $donnees2["id"] ?>>
                              <input type="hidden" name="type" value= "Section">
                              <button type="submit" class="btn btn-info">Modifier le nom</button>
                            </form>
                          </td>

                          </tr>
                        <?php
                        }
                     ?>
                  </tbody>
              </table>
      <h3><i class="fas fa-users mr-2"></i>Leçons</h3>
      </div>
        <div class="card-body pr-2 pl-2">

          <table id="example" class="table table-striped table-bordered" style="width:100%">
                  <thead>
                    <tr>
                      <th  class="text-center">Nom</th>
                      <th  class="text-center">Description</th>
                      <th  class="text-center">Documents</th>
                      <th  class="text-center">Modifier</th>
                
                    </tr>
                  </thead>
                  <tbody>
                  <tr class="text-center">    
                    <?php
                      //Affiche les leçons d'un instructeur par id
                        $reponse = $bdd->query('SELECT DISTINCT Nom,id,Description FROM lecon where Creator ='.Session::get('id'));
                        while ($donnees3 = $reponse->fetch())
                        {
                          ?>
                          <td><?php echo $donnees3['Nom'] ; ?></td>
                          <td><?php echo $donnees3['Description'] ; ?></td>
                          <td><ul>
                            <?php
                              $r = $bdd->query('SELECT DISTINCT DocName FROM lecondocs where LeconId = '.$donnees3["id"]);
                              while ($d = $r->fetch())
                              {?>
                                  <li><?php echo $d["DocName"] ; ?></li>
                              <?php
                              }
                            ?>
                          </ul></td>
                          <td>
                            <form method="post" action="#">
                              <label>Nouveau nom :</label><input type='text' name="name2">
                              <input type='hidden' name="id2" value=<?php echo $donnees3["id"] ?>>
                              <input type="hidden" name="type" value= "Lecon">
                              <button type="submit" class="btn btn-info">Modifier le nom</button>
                            </form>
                          </td>
                      </tr>
                      <?php
                      }
                     ?>
                  </tbody>
              </table>
        </div>
      </div>
      </div>
        </div>
