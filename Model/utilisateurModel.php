<?php
include("connexion.php");
class Utilisateur
{
    
    private $login;
    private $password;
    private $nom;
    private $cin;
    private $date_naiss;
    private $email;
    private $role=0;
    function __construct($login,$password,$nom,$cin,$date_naiss,$email) {
        $this->login=$login;
        $this->password=$password;
        $this->nom=$nom;
        $this->cin=$cin;
        $this->date_naiss=$date_naiss;
        $this->email=$email;
    }
    public function __get($attr) {
        if (!isset($this->$attr))
            return "erreur";
        else 
            return ($this->$attr);
    }
    public function __set($attr,$value) {
        $this->$attr = $value; 
    }
    public function __isset($attr) {
        return isset($this->$attr );
    }
    public static function login($login,$password){
        $bd=connexion("formation");
        $sql="SELECT role from utilisateur where login=:login AND password=:password";
        $stmt=$bd->prepare($sql);
        $stmt->bindParam(":login",$login);
        $stmt->bindParam(":password",$password);
        $res=$stmt->execute();
        if($r=$stmt->fetch(PDO::FETCH_ASSOC)){
            return $r["role"];
        }else return -1;

    }
    public static function isUserExist($login){
        $bd = connexion("formation");
        $sql="SELECT login from utilisateur where login=:login";
        $stmt=$bd->prepare($sql);
        $stmt->bindParam(":login",$login);
        $stmt->execute();
        if($stmt->rowCount()>0)
            return false;
        return true;

    }
    public static function createUser($login,$password,$nom,$cin,$date_naiss,$email){
        $bd = connexion("formation");
        if(!Utilisateur::isUserExist($login)){
            return false;
        }
        $sql = "INSERT INTO utilisateur (login, password, nom, cin, date_naiss, email, role) VALUES (:login, :password, :nom, :cin, :date_naiss, :email,0)";
        $stmt = $bd->prepare($sql);
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':cin', $cin);
        $stmt->bindParam(':date_naiss', $date_naiss);
        $stmt->bindParam(':email', $email);
        if($stmt->execute()){
            return true;
        }
        return false;

    }
}


?>