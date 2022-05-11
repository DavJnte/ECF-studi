<?php

include "config/config.php";


class  Database{

  public $pdo;


  //Connexion à la BDD
  public function __construct(){

    if (!isset($this->pdo)) {
      try {
        $link = new PDO("mysql:host=localhost;dbname=db_ecoit;charset=utf8", "root", "root");
        $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $link->exec("SET CHARACTER SET utf8");
        $this->pdo  =  $link;
      } catch (PDOException $e) {
        die("Connection error...".$e->getMessage());
      }

    }

  }








}
