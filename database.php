<?php

class Database{

      protected $host;
      protected $dbname;
      protected $user;
      protected $password;
      protected $db;

      //Constructor
      public function __construct($_host , $_dbname , $_user , $_password){
            $this -> host = $_host;
            $this -> dbname = $_dbname;
            $this -> user = $_user;
            $this -> password = $_password;

            try{
                  $this -> db = new PDO('mysql:host='.$this -> host.';dbname='.$this -> dbname.';charset=utf8', ''.$this -> user.'', ''.$this ->password.'');
            }
            catch(Exception $e){
                  die('Erreur : '.$e->getMessage());
            }
      }

      //POTEAUX INCENDIES
        public function addPoteaux($name , $description , $adresse , $latitude , $longitude){
            $req = $this-> db -> prepare("INSERT INTO poteau(nom,description,adresse,latitude,longitude) VALUES(:nom,:description,:adresse,:latitude,:longitude)");
            $req -> execute(array(
                'nom' => $name,
                'description' => $description,
                'adresse' => $adresse,
                'latitude' => $latitude,
                'longitude' => $longitude
            ));
            echo("Poteaux enregistré!");
    }

        public function deletePot($id){
            $req = $this -> db -> prepare('DELETE FROM poteau WHERE id = :id');
            $req -> execute(array(
                'id' => $id
            ));
            echo("Poteaux supprimmé!");
    }

        public function getPoteaux(){
        $req = $this -> db -> query("SELECT * FROM poteau");
        return $req;
    }

    public function addDonnees($id_poteau , $debit , $date){
    $req = $this-> db -> prepare("INSERT INTO donees(id_poteau ,debit,date) VALUES(:id_poteau ,:debit,:date)");
    $req -> execute(array(
        'id_poteau' => $id_poteau,
        'debit' => $debit,
        'date' => $date
    ));
    }

    public function deleteDonnees($id){
        $req = $this -> db -> prepare('DELETE FROM donees WHERE id = :id');
        $req -> execute(array(
            'id' => $id
        ));
    }

    public function getDonnees($begin , $end){
        $req_donnees = $this -> db -> query('SELECT * FROM donees ORDER BY date DESC LIMIT '.$begin.','.$end);
        return $req_donnees;
    }

    public function validGetId($id){
        $req = $this -> db -> prepare("SELECT id FROM poteau WHERE id = :id");
        $req -> execute(array(
            'id' => $id
        ));
        if($req -> rowCount() != 0){
            return false;
        }
        else{
            return true;
        }
    }

    public function getUniqueDonnees($id_poteau){
        $req = $this -> db -> prepare("SELECT * FROM donees  WHERE id_poteau = ? ORDER BY date DESC");
        $req -> execute(array($id_poteau));
        return $req;
    }

    public function getUniquePoteau($id){
        $req = $this -> db -> prepare("SELECT * FROM poteau WHERE id = ?");
        $req -> execute(array($id));
        return $req;
    }

    public function verifyPassword($password){
        $req = $this -> db -> prepare("SELECT passwd FROM password");
        $req -> execute();
        $data = $req -> fetch();
        if(password_verify($password , $data['passwd'])){
            return true;
        }
        else{
            return false;
        }
    }

    public function changePasswd($password){
        $req= $this -> db -> prepare("UPDATE password SET passwd = ? WHERE id = 1 ");
        $hash_password = password_hash($password , PASSWORD_BCRYPT);
        $req -> execute(array($hash_password));
        return $req;
    }

    public function getTotalDonnees(){
        $req = $this -> db -> query("SELECT id FROM donees");
        $reqCount = $req -> rowCount();
        return $reqCount;
    } 
}