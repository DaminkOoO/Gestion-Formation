<?php
include("../Model/formationModel.php");
include("../Model/ReservationModel.php");
if(isset($_GET["add"])){
    if(isset($_GET['title'], $_GET['trainer'], $_GET['description'], $_GET['date'], $_GET['price'], $_GET['seats'])) {
        if(!empty($_GET['title']) && !empty($_GET['trainer']) && !empty($_GET['description']) && !empty($_GET['date']) && !empty($_GET['price']) && !empty($_GET['seats'])) {
            $titre = $_GET['title'];
            $formateur = $_GET['trainer'];
            $description = $_GET['description'];
            $date = $_GET['date'];
            $prix = $_GET['price'];
            $nbPlace = $_GET['seats'];
            echo Formation::getNextId();
            $date=date("Y-m-d H:i:s",strtotime($date));
            $formation= new Formation(Formation::getNextId(),$titre,$formateur,$description,$date,$nbPlace,0,$prix,0,0);
            $formation->addFormation();
            header("Location: ../View/admin/admin.php");
        }
      }
}
if(isset($_GET["ref"])){
    $ref=$_GET["ref"];
    if(isset($_GET["nbReservation"])){
        $nbReservation=$_GET["nbReservation"];
        session_start();
        $_SESSION["refFormation"]=$ref;
        $_SESSION["nbReservation"]=$nbReservation;
        header("Location: ../View/Admin/reservationEnAttente.php");
    }
    if(isset($_GET["supp"])){

    }
}
if(isset($_GET["changerEtat"])){
    session_start();
    $res=Reservation::addReservation($_GET["changerEtat"],$_SESSION['username']);

    if($res){
        
        header("Location: ..");
    }

        
    else{
        echo $res;
    }
}
if(isset($_GET["sbt"])){
    $score=$_GET["score"];
    $id_formation=$_GET["id_formation"];
    echo Formation::updateScore($id_formation,$score);
    header("Location: ..");
}
if(isset($_GET["conf"])){
    $id_formation=$_GET["id_formation"];
    $id=$_GET["conf"];
    if(!Reservation::confirmer($id_formation,$id))
        echo "<script>alert (\"Erreur\")</script>";
    header("Location: ../View/admin/admin.php");
}
if(isset($_GET["supp"])){
    echo Formation::deleteById($_GET["id_formation"]);
    header("Location: ../View/admin/admin.php");
}
