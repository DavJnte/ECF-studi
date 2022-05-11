<?php
include 'inc/header.php';
Session::CheckSession();
include 'get_bdd.php';	

// Remplir les champs pour inserer dans la table leçon les nouvelles documentations
$req = $bdd->query("SELECT* FROM lecon");
if(isset($_POST["leconid"])){
		$target_dir = "Documents/";
		$target_file = $target_dir . basename($_FILES["file"]["name"]);
		
		if($target_file != $target_dir){
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			if (file_exists($target_file)) {
			echo "Vidéo déjà utilisé veuillez en choisir une autre.";
			
			}
			if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
				header('index.php');
			} else {
			echo "Erreur d'enregistrement.";
			}
			$sql = "INSERT INTO lecondocs (LeconId, DocPath,DocName) VALUES (".$_POST['leconid'].",'".$target_file."','".$_FILES["file"]['name']."')";
			print($sql);
			try{
				$stmt = $bdd->prepare($sql);
				$req = $stmt->execute();
			}catch(PDOException $e){
				echo $e->getMessage().'<br/>';
			}
			header("Refresh:0");
		}else{
			echo "Choisir un fichier";
		}
  }
?>
<!--Formulaire de modification de leçon -->
<div class="card ">
   <div class="card-header">
          <h3  class='text-center'>Modifier une Leçon</h3>
        </div>
		<br>
        <div class="card-body">
		<table id="examples" class="table-striped table-bordered" style="width:100%">
						<thead>
						<tr>
						<th  class="text-center">Nom</th>
						<th  class="text-center">Description</th>
						<th  class="text-center">Video/Image</th>
						<th  class="text-center">Documents</th>
						<th  class="text-center">Ajouter Document</th>
						</tr>
					</thead>
					<tbody>
					<tr class="text-center">
						
<?php

//affiche dans le tableau les données de la table
foreach($req->fetchAll() as $lecon){
	?><td><?php echo $lecon["Nom"] ?></td><?php
	?><td><?php echo $lecon["Description"] ?></td><?php
	$path = $lecon["VideoPath"] ;
	if(strpos($lecon["VideoName"],"mp4")){
		echo("<td>\n<video style='max-height: 150px; id: videos' src='".$path."' controls ></video></td>\n");
	}else{
		echo("<td>\n<img style='max-width:150px;'src='".$path."'></td>\n");
	}
	$req = $bdd->query("SELECT * from lecondocs where LeconId=".$lecon["id"]);
	?>
	<td>
	<ul>
	<?php
	//Telecharger un document depuis l'interface de modification de leçon
	foreach($req->fetchAll() as $docrow){
		$doc = $docrow["DocPath"] ;
		$docname = $docrow["DocName"];
		?>
		<li><a download=' <?php echo $docname ?>' href='<?php echo $doc ?>'>Telecharger <?php echo $docname ?></a></br></li>
		<?php
	}?>
	</td>
	<td>
		<!--Ajout d'un document si oublie de l'instructeur-->
		<form method="post" action="#" enctype="multipart/form-data">
			<input type="file" name="file" >
			<input type="hidden" name="leconid" value="<?php echo $lecon['id'] ?>">
			<br>
			<br>
			<button id="button" type="submit" class="btn btn-success">Ajouter un document</button>
		</form>
	</td>
	</tr>
	<?php
}
?>

  </tbody>
</table>

<?php
include 'inc/footer.php';
?>