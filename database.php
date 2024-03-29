<?php

class Database{

      protected $host;
      protected $dbname;
      protected $user;
      protected $password;
      protected $db;

      //Constructor
      public function __construct($path){
            static $connection;
                if(!isset($connection)) {
                    $config = parse_ini_file($path); 
                    
                    $this -> host = $config['servername'];
                    $this -> dbname = $config['dbname'];
                    $this -> user = $config['username'];
                    $this -> password = $config['password'];

                    try{
                        $this -> db = new PDO('mysql:host='.$this -> host.';dbname='.$this -> dbname.';charset=utf8', ''.$this -> user.'', ''.$this ->password.'');
                    }
                    catch(Exception $e){
                        die('Erreur : '.$e->getMessage());
                    }
                }
                    if($connection === false) {
                        return false; 
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
            
    }

        public function deletePot($id){
            $req = $this -> db -> prepare('DELETE FROM poteau WHERE id = :id');
            $req -> execute(array(
                'id' => $id
            ));
    }

    public function getPoteaux($begin , $end){
        $req_poteaux = $this -> db -> query('SELECT * FROM poteau LIMIT '.$begin.','.$end);
        return $req_poteaux;
    }

    public function displayPoteaux(){
        $req_poteaux = $this -> db -> query('SELECT * FROM poteau');
        return $req_poteaux;
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

    public function getTotalpoteaux(){
        $req = $this -> db -> query("SELECT id FROM poteau");
        $reqCount = $req -> rowCount();
        return $reqCount;
    } 

    //INSTALLEUR

    public function createTableDonnees(){
        try {
            $this -> db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "CREATE TABLE donees(
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                id_poteau INT(11) UNSIGNED,
                debit DOUBLE,
                date DATE
            )";
            $this -> db -> exec($sql);
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function createTablePoteau(){
        try {
            $this -> db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "CREATE TABLE poteau(
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                nom VARCHAR(255),
                latitude DOUBLE,
                longitude DOUBLE,
                description TEXT,
                adresse TEXT

            )";

            $this -> db -> exec($sql);
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function createTablePassword(){
       try {
            $this -> db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "CREATE TABLE password(
                id INT(11),
                passwd TEXT

            )";

            $this -> db -> exec($sql);
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function addPasswd($password){
        if(is_numeric($password)){
            $password = password_hash($password,PASSWORD_BCRYPT);
            $req_donnees = $this -> db -> query("INSERT INTO password (id,passwd) VALUES('1','$password') ");
            return true;
        }
        else{
            return false;
        }
    }

    public function mapPoteau(){
        $mysqli = new mysqli($this -> host,$this -> user,$this -> password, $this -> dbname);
        if(!$mysqli){
            die("Connection failed: " . $mysqli->error);
        }
        $query =  $mysqli ->prepare("SELECT * FROM poteau");
        $query -> execute();
        $result = $query-> get_result();
        while($row = $result -> fetch_assoc()){
            $data[] = $row;
        }
        $result->close();
        $mysqli->close();
        echo json_encode($data);
    }

    public function chartJSON($id_poteau){
            
        $mysqli = new mysqli($this -> host,$this -> user,$this -> password, $this -> dbname);
        if(!$mysqli){
            die("Connection failed: " . $mysqli->error);
        }
        $query =  $mysqli -> prepare("SELECT debit , date FROM donees WHERE id_poteau = ? ORDER BY date ASC");
        $query -> bind_param("i",$id_poteau);
        $query -> execute();
        $result = $query-> get_result();
        while($row = $result -> fetch_assoc()){
            $data[] = $row;
        }
        $result->close();
        $mysqli->close();
        print json_encode($data);
    }
}