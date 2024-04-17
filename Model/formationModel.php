<?php
include("connexion.php");
class Formation{
    private $id;
    private $intitule;
    private $formateur;
    private $description;
    private $date;
    private $nbPlace;
    private $nbReservation;
    private $prix;
    private $score;
    private $nbScore;
    private $listFormation;
    function __construct($id,$intitule,$formateur,$description,$date,$nbPlace,$nbReservation,$prix,$score,$nbScore) {
        $this->id=$id;
        $this->intitule= $intitule;
        $this->formateur=$formateur;
        $this->description = $description;
        $this->date = $date;
        $this->nbPlace = $nbPlace;
        $this->nbReservation = $nbReservation;
        $this->prix = $prix;
        $this->score=$score;
        $this->nbScore=$nbScore;
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
    public static function addReservation($id_formation){
        $bd=connexion("formation");
        $sql="UPDATE formation set nbReservation=nbReservation+1 where id=:id_formation";
        $stmt=$bd->prepare($sql);
        $formation=Formation::getInfoFormation($id_formation);
        $bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt->bindParam(":id_formation",$id_formation);
        $stmt->execute();
    }
    public static function updateScore($id_formation,$score){
        
        $bd=connexion("formation");
        $sql="UPDATE formation set score=:score,nbScore=nbScore+1 where id=:id_formation";
        $stmt=$bd->prepare($sql);
        $formation=Formation::getInfoFormation($id_formation);
        $bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $calculatedScore=(($formation->nbScore)*($formation->score)+$score)/(($formation->nbScore)+1);
        $stmt->bindParam(":score",$calculatedScore);
        $stmt->bindParam(":id_formation",$id_formation);
        $res=$stmt->execute();
        return $bd->errorInfo()[2];
        
    }
    public static function getInfoFormation($id_formation){
        $listFormation = Formation::getAllFormation();
        foreach($listFormation as $formation){
            if($formation->id==$id_formation){
                return $formation;
            }
        }
        return false;
    }
    public static function deleteById($id) {

        $bd=connexion("formation");
        $bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $bd->prepare("DELETE FROM formation WHERE id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $bd->errorInfo()[2];
    }

    public function getInfo($idUser){
        $stars = '';
        for($i=0; $i<5; $i++){
            if($i<$this->score)
                $stars .= '&starf;';
            else 
                $stars .= '&star;';
        }   

        return '<tr>
            <td><a href="View/formation.php?id_formation='.$this->id.'">' . $this->intitule . '</a></td>
            <td>' . $this->formateur . '</td>
            <td>' . $this->date . '</td>
            <td>' . $this->prix . '</td>
            <td>' . ($this->nbPlace-$this->nbReservation) . '</td>
            <td style="color:yellow;">'.$stars.'</td>
            <td>' . $this->getReservationEtat($idUser) . '</td>
        </tr>';
    }
    public function getReservationEtat($idUser){
        $bd=connexion("formation");
        $sql="SELECT etat from Reservation where login=:login AND id_formation=:id_formation";
        $stmt=$bd->prepare($sql);
        $stmt->bindParam(":login",$idUser);
        $stmt->bindParam(":id_formation",$this->id);
        $res=$stmt->execute();
        if($r=$stmt->fetch(PDO::FETCH_ASSOC)){
            return $r["etat"]==0?"Pending":"Confirmed";
        }else return ($this->nbPlace-$this->nbReservation)>0?"<a href='Controller/formationController.php?changerEtat=$this->id'>I want to join</a>":"No Reservation Available!";
    }
    public function __toString() {
        return 
        "<tr>
            <td>$this->intitule</td>
            <td>$this->nbPlace</td>
            <td>$this->nbReservation</td>
            <td><a href='reservationEnAttente.php?ref=$this->id&nbReservation=$this->nbReservation&intituleFormation=$this->intitule'>Number of pending reservations</a></td>
            <td><a href='../../Controller/formationController.php?supp=supprimer&id_formation=$this->id'>Delete</a></td>
        </tr>";
    }
    public static function getNextId(){
        $bd = connexion("formation");
        $stmt = $bd->query("SELECT id FROM formation ORDER BY id DESC LIMIT 1");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $lastId = $row !== false?$row['id']+1:1;
        return $lastId;
    }
    
    public static function getAllFormation(){
        $listFormation = array();
        $bd=connexion("formation");
        $stmt = $bd->query("SELECT * FROM formation");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $ObjectFormation= new Formation($row["id"],$row["intitule"],$row["formateur"],$row["description"],$row["date"],$row["nbPlace"],$row["nbReservation"],$row["prix"],$row["score"],$row["nbScore"]);
            $listFormation[]=$ObjectFormation;
        }
        return $listFormation;

    }
    public function addFormation()
    {
        $bd = connexion("formation");
        $sql = "INSERT INTO formation(id, intitule, formateur, description, date, nbPlace, nbReservation, prix, score, nbScore) VALUES (:id,:intitule,:formateur,:description,:date,:nbPlace,:nbReservation,:prix,:score,:nbscore)";
        $stmt = $bd->prepare($sql);
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':intitule', $this->intitule);
        $stmt->bindParam(':formateur', $this->formateur);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':date', $this->date);
        $stmt->bindParam(':nbPlace', $this->nbPlace);
        $stmt->bindParam(':nbReservation', $this->nbReservation);
        $stmt->bindParam(':prix', $this->prix);
        $stmt->bindParam(':score', $this->score);
        $stmt->bindParam(':nbscore', $this->nbScore);
        if($stmt->execute()){
            return true;
        }
        return false;
    }
}

?>