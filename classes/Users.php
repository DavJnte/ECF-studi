<?php

include 'lib/Database.php';
include_once 'lib/Session.php';


class Users{


  // Db Property
  private $db;

  // Db __construct Method
  public function __construct(){
    $this->db = new Database();
  }

  // fonction date 
   public function formatDate($date){
      $strtime = strtotime($date);
    return date('Y-m-d H:i:s', $strtime);
   }



  // Verification du mail de l'utiisateur
  public function checkExistEmail($email){
    $sql = "SELECT email from users WHERE email = :email";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':email', $email);
     $stmt->execute();
    if ($stmt->rowCount()> 0) {
      return true;
    }else{
      return false;
    }
  }

  //fonction postuler pour faire des demandes
  public function postuler(){
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $spe = $_POST['specialite'];
    $mdp =$_POST['mdp'];
    $image=$_FILES['image']['name'];

    if ($nom == "" || $email == "" || $spe == "" || $prenom == "" || $mdp == "") {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Attention !</strong> Les champs ne doivent pas être vide !</div>';
        return $msg;
    }else{

      $sql = "INSERT INTO demande (nom, prenom, email, specialite, mdp, image) values(:nom,:prenom,:email,:specialite,:mdp,:image)";
      $stmt = $this->db->pdo->prepare($sql);
      $stmt->bindValue(':nom', $nom);
      $stmt->bindValue(':prenom', $prenom);
      $stmt->bindValue(':email', $email);
      $stmt->bindValue(':specialite', $spe);
      $stmt->bindValue(':mdp', $mdp);
      $stmt->bindValue(':image', $image);
      $result = $stmt->execute();

      if ($result) {
        $msg = '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Demande envoyé !</strong></div>';
          return $msg;
      }else{
        $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Erreur !</strong>Veuillez réessayer !</div>';
          return $msg;
      }
    }
  }


//fonction pour afficher les demandes en cours
  public function selectalldemande(){
    $sql = "SELECT * FROM demande ORDER BY id";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }


  // Enregistrement utilistateur
  public function userRegistration($data){
    $username = $data['username'];
    $email = $data['email'];
    $roleid = $data['roleid'];
    $password = $data['password'];

    $checkEmail = $this->checkExistEmail($email);

    if ($username == "" || $email == "" || $password == "") {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Erreur !</strong> Les champs ne doivent pas être vide !</div>';
        return $msg;
    }elseif (strlen($username) < 3) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Erreur !</strong> Le nom de l utilisateur est trop court, remplisez au moins 3 caractères. !</div>';
        return $msg;
    }elseif(strlen($password) < 5) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Erreur !</strong> Mot de passe doit faire au moins 6 caractères!</div>';
        return $msg;
    }elseif(!preg_match("#[0-9]+#",$password)) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Erreur !</strong> Votre mot de passe doit contenir au moins un chiffre !</div>';
        return $msg;
    }elseif(!preg_match("#[a-z]+#",$password)) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Erreur !</strong> Votre mot de passe doit contenir au moins un chiffre !</div>';
        return $msg;

    }elseif (filter_var($email, FILTER_VALIDATE_EMAIL === FALSE)) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Erreur !</strong>Ce compte inexistant !</div>';
        return $msg;
    }elseif ($checkEmail == TRUE) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Error !</strong> Cet Email déjà utilisé, Vueillez choisir une autre !</div>';
        return $msg;
    }else{

      $sql = "INSERT INTO users(username, email, password, roleid) VALUES(:username, :email, :password, :roleid)";
      $stmt = $this->db->pdo->prepare($sql);
      $stmt->bindValue(':username', $username);
      $stmt->bindValue(':email', $email);
      $stmt->bindValue(':password',SHA1($password));
      $stmt->bindValue(':roleid', $roleid);
      $result = $stmt->execute();

      if ($result) {
        $msg = '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Réussi !</strong></div>';
          return $msg;
      }else{
        $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Erreur !</strong>Veuillez réessayer !</div>';
          return $msg;
      }
    }

  }



  // Ajout d'un utilisateur 
  public function addNewUserByAdmin($data){
    $username = $data['username'];
    $email = $data['email'];
    $roleid = $data['roleid'];
    $password = $data['password'];

    $checkEmail = $this->checkExistEmail($email);

    if ($username == "" || $email == "" || $password == "") {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Erreur !</strong> Les champs ne doivent pas être vides !</div>';
        return $msg;
    }elseif (strlen($username) < 3) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Erreur !</strong>  Le nom de l utilisateur est trop court,il doit contenir au moins 3 caractères !</div>';
        return $msg;
    }elseif(strlen($password) < 5) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Erreur !</strong>  Mot de passe doit avoir moins 6 caractères !</div>';
        return $msg;
    }elseif(!preg_match("#[0-9]+#",$password)) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Erreur !</strong> Votre mot de passe doit contenir au moins un chiffre. !</div>';
        return $msg;
    }elseif(!preg_match("#[a-z]+#",$password)) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Erreur!</strong> Votre mot de passe doit contenir au moins un chiffre. !</div>';
        return $msg;
    }elseif (filter_var($email, FILTER_VALIDATE_EMAIL === FALSE)) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Erreur !</strong>Email incorrect !</div>';
        return $msg;
    }elseif ($checkEmail == TRUE) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Erreur !</strong> Cet Email déjà utilisé,Vueillez en choisir une autre ... !</div>';
        return $msg;
    }else{

      $sql = "INSERT INTO users(username, email, password, roleid) VALUES(:username, :email, :password, :roleid)";
      $stmt = $this->db->pdo->prepare($sql);
      $stmt->bindValue(':username', $username);
      $stmt->bindValue(':email', $email);
      $stmt->bindValue(':password',SHA1($password));
      $stmt->bindValue(':roleid', $roleid);
      $result = $stmt->execute();

      if ($result) {
        $msg = '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Enregistrement Réussi !</strong></div>';
          return $msg;
      }else{
        $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Erreur Enregistrement !</strong> !</div>';
          return $msg;
      }
    }
  }


  // Affiche tous les utilisateurs par ID
  public function selectAllUserData(){
    $sql = "SELECT * FROM users ORDER BY id DESC";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }


  // Authentification des utilisateurs 
  public function userLoginAutho($email, $password){
    $password =SHA1($password);
    $sql = "SELECT * FROM users WHERE email = :email and password = :password LIMIT 1";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':password', $password);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_OBJ);
  }

  // Verification du Status actif de l'utilisateur
  public function CheckActiveUser($email){
    $sql = "SELECT * FROM users WHERE email = :email and isActive = :isActive LIMIT 1";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':isActive', 1);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_OBJ);
  }



    // Verification des identifiant utilisateur lors de la connexion
    public function userLoginAuthotication($data){
      $email = $data['email'];
      $password = $data['password'];
      $checkEmail = $this->checkExistEmail($email);

      if ($email == "" || $password == "" ) {
        $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Erreur !</strong> Email ou mot de passe incorrect !</div>';
          return $msg;

      }elseif (filter_var($email, FILTER_VALIDATE_EMAIL === FALSE)) {
        $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Erreur !</strong> Email incorrect !</div>';
          return $msg;
      }elseif ($checkEmail == FALSE) {
        $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Erreur !</strong> Email introuvable !</div>';
          return $msg;
      }else{


        $logResult = $this->userLoginAutho($email, $password);
        $chkActive = $this->CheckActiveUser($email);

        if ($chkActive == TRUE) {
          $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <strong>Erreur !</strong> Désolé, votre compte à été désactivé ! </div>';
            return $msg;
        }elseif ($logResult) {

          Session::init();
          Session::set('login', TRUE);
          Session::set('id', $logResult->id);
          Session::set('roleid', $logResult->roleid);
          Session::set('name', $logResult->name);
          Session::set('email', $logResult->email);
          Session::set('username', $logResult->username);
          Session::set('logMsg', '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Authentification réussie !</strong></div>');
          echo "<script>location.href='index.php';</script>";

        }else{
          $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <strong>Erreur !</strong> Email ou Mot de passe incorrect !</div>';
            return $msg;
        }
      }
    }


    // fonction information de l'utilisateur par son id
    public function getUserInfoById($userid){
      $sql = "SELECT * FROM users WHERE id = :id LIMIT 1";
      $stmt = $this->db->pdo->prepare($sql);
      $stmt->bindValue(':id', $userid);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_OBJ);
      if ($result) {
        return $result;
      }else{
        return false;
      }
    }


  // Fonction information de l'utilisateur (son role, mail, pseudo)
    public function updateUserByIdInfo($userid, $data){
      $username = $data['username'];
      $email = $data['email'];
      $roleid = $data['roleid'];



      if ($username == ""|| $email == "" ) {
        $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Erreur !</strong> Les champs ne doivent pas être vides !</div>';
          return $msg;
        }elseif (strlen($username) < 3) {
          $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <strong>Erreur !</strong>  Le nom de l utilisateur est trop court,il doit contenir au moins 3 caractères !</div>';
            return $msg;
        }elseif (filter_var($email, FILTER_VALIDATE_EMAIL === FALSE)) {
        $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Erreur !</strong>  Email incorrect !</div>';
          return $msg;
      }else{

        $sql = "UPDATE users SET
          username = :username,
          email = :email,
          roleid = :roleid
          WHERE id = :id";
          $stmt= $this->db->pdo->prepare($sql);
          $stmt->bindValue(':username', $username);
          $stmt->bindValue(':email', $email);
          $stmt->bindValue(':roleid', $roleid);
          $stmt->bindValue(':id', $userid);
          $result =   $stmt->execute();

        if ($result) {
          echo "<script>location.href='index.php';</script>";
          Session::set('msg', '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Mise à jour Réussi !</strong></div>');
        }else{
          echo "<script>location.href='index.php';</script>";
          Session::set('msg', '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Erreur !</strong> Mise à jour échoué !</div>');
        }
      }
    }


    // Supprimer un utilisateur
    public function deleteUserById($remove){
      $sql = "DELETE FROM users WHERE id = :id ";
      $stmt = $this->db->pdo->prepare($sql);
      $stmt->bindValue(':id', $remove);
        $result =$stmt->execute();
        if ($result) {
          $msg = '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Réussi !</strong> Utilisateur Supprimé !</div>';
            return $msg;
        }else{
          $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Erreur !</strong> Compte non supprimé !</div>';
            return $msg;
        }
    }

    public function deletedemande($removed){
      $sql = "DELETE FROM demande WHERE id limit 1";
      $stmt = $this->db->pdo->prepare($sql);
      $stmt->bindValue(':id', $removed);
        $result =$stmt->execute();
        if ($result) {
          $msg = '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Suppression Réussie !</strong> Suppression de la demande effectué !</div>';
            return $msg;
        }else{
            $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Erreur !</strong></div>';
            return $msg;
        }
    }

    // Fonction désactiver un utilisateur 
    public function userDeactiveByAdmin($deactive){
     
       $sql = "UPDATE users SET
       isActive=:isActive
       WHERE id = :id";
       $stmt = $this->db->pdo->prepare($sql);
       $stmt->bindValue(':isActive', 1);
       $stmt->bindValue(':id', $deactive);
       $result =   $stmt->execute();

        if ($result) {
          echo "<script>location.href='index.php';</script>";
          Session::set('msg', '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Réussi !</strong>Le compte de l utilisateur à été désactivé !</div>');

        }else{
          echo "<script>location.href='index.php';</script>";
          Session::set('msg', '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Erreur !</strong></div>');
        }
    }


    //Fonction réactiver un utilisateur
    public function userActiveByAdmin($active){
      $sql = "UPDATE users SET
       isActive=:isActive
       WHERE id = :id";
       $stmt = $this->db->pdo->prepare($sql);
       $stmt->bindValue(':isActive', 0);
       $stmt->bindValue(':id', $active);
       $result =   $stmt->execute();

        if ($result) {
          echo "<script>location.href='index.php';</script>";
          Session::set('msg', '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Réussi !</strong> Le compte de l utilisateur à été réactivé !</div>');
        }else{
          echo "<script>location.href='index.php';</script>";
          Session::set('msg', '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                      <strong>Erreur !</strong></div>');
        }
    }


    // Vérification de l'ancien mot de passe
    public function CheckOldPassword($userid, $old_pass){
      $old_pass =SHA1($old_pass);
      $sql = "SELECT password FROM users WHERE password = :password AND id =:id";
      $stmt = $this->db->pdo->prepare($sql);
      $stmt->bindValue(':password', $old_pass);
      $stmt->bindValue(':id', $userid);
      $stmt->execute();
      if ($stmt->rowCount() > 0) {
        return true;
      }else{
        return false;
      }
    }



    //fonction update Mot passe changé avec un nouveau 
    public  function changePasswordBysingelUserId($userid, $data){

      $old_pass = $data['old_password'];
      $new_pass = $data['new_password'];


      if ($old_pass == "" || $new_pass == "" ) {
        $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Erreur !</strong> Le champ du mot de passe ne doit pas être vide !</div>';
          return $msg;
      }elseif (strlen($new_pass) < 6) {
        $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Erreur !</strong> Le nouveau mot de passe doit comporter au moins 6 caractères !</div>';
          return $msg;
       }

         $oldPass = $this->CheckOldPassword($userid, $old_pass);
         if ($oldPass == FALSE) {
           $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Erreur !</strong> Ancien mot de passe ne correspond pas !</div>';
             return $msg;
        }else{

           $new_pass = SHA1($new_pass);
           $sql = "UPDATE users SET
            password=:password
            WHERE id = :id";
            $stmt = $this->db->pdo->prepare($sql);
            $stmt->bindValue(':password', $new_pass);
            $stmt->bindValue(':id', $userid);
            $result =   $stmt->execute();

          if ($result) {
            echo "<script>location.href='index.php';</script>";
            Session::set('msg', '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Réussi !</strong> Mot de passe changé !</div>');

          }else{
            $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Erreur !</strong> Impossible de changer le mot de passe !</div>';
              return $msg;
          }
        }
    }
}

