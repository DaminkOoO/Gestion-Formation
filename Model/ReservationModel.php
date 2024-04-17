<?php
class Reservation{
    private $id;
    private $etat;
    private $login;
    private $id_formation;
    function __construct($id,$etat,$login,$id_formation){
        $this->id=$id;
        $this->etat=$etat;
        $this->login=$login;
        $this->id_formation=$id_formation;
    }
    public function __get($attr) {
        if (!isset($this->$attr)) return "erreur";
           else return ($this->$attr);}
    public function __set($attr,$value) {
        $this->$attr = $value; 
    }
    public function __isset($attr) {
        return isset($this->$attr );
    }
    public function __toString() {
        return "<tr><td>{$this->id}</td><td>{$this->login}</td><td>{$this->id_formation}</td><td><a href='../../Controller/formationController.php?conf={$this->id}&if_formation={$this->id_formation}'>Confirmer</a></td></tr>";
    }
    public static function confirmer($id_formation,$id){

            $bd = connexion("formation");
            $stmt = $bd->prepare("SELECT count(id) as count from reservation where id_formation= :id_formation AND etat=1");
            $stmt->bindParam(':id_formation', $id_formation, PDO::PARAM_INT);
            $stmt->execute();
            $count = $stmt->fetch(PDO::FETCH_ASSOC);

            $stmt = $bd->prepare("SELECT nbPlace from Formation where id= :id_formation");
            $stmt->bindParam(':id_formation', $id_formation, PDO::PARAM_INT);
            $stmt->execute();
            $nbPlace = $stmt->fetch(PDO::FETCH_ASSOC);
            if($nbPlace==$count)
                return false;
            else{
                $stmt = $bd->prepare("UPDATE reservation SET etat=1 WHERE id= :id");
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
                if($stmt->execute()){
                    $stmt = $bd->prepare("UPDATE formation SET nbReservation=nbReservation+1 WHERE id= :id_formation");
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                    return $stmt->execute();
                }else return false;
                
            }
    }
    public static function getNextId(){
        $bd = connexion("formation");
        $stmt = $bd->query("SELECT id FROM reservation ORDER BY id DESC LIMIT 1");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $lastId = $row !== false?$row['id']+1:1;
        return $lastId;
    }
    public static function addReservation($id_formation, $login){
        $bd = connexion("formation");
        $sql = "INSERT INTO reservation(id, etat, login, id_formation) VALUES (:id,0,:login,:id_formation)";
        $stmt = $bd->prepare($sql);
        $nextId = Reservation::getNextId();
        $stmt->bindParam(':id', $nextId);
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':id_formation', $id_formation);
        $bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public static function getReservation(){
        $listReservation = array();
        $bd=connexion("formation");
        $stmt = $bd->query("SELECT * FROM reservation");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $ObjectReservation= new Reservation($row["id"],$row["etat"],$row["login"],$row["id_formation"]);
            $listReservation[]=$ObjectReservation;
        }
        return $listReservation;
    }
    public static function getReservationNonConfirmer(){
        $listReservationNonConfirmer = array();
        $listReservation=Reservation::getReservation();
        foreach($listReservation as $reservation){
            if($reservation->etat==0){
                $listReservationNonConfirmer[]=$reservation; 
            }
        }
        return $listReservationNonConfirmer;
}
}

?>