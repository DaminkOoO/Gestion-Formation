<?php
    include("../Model/utilisateurModel.php");
    if(isset($_POST["login"])&&!empty($_POST["login"])){
        $role=Utilisateur::login($_POST["username"],$_POST["password"]);
        if($role!=-1){
            session_start();
            echo $_POST["username"].$_POST["password"];
            $_SESSION['username'] = $_POST["username"];
            $_SESSION["role"]=$role;
            $role==1?header("Location: ../"):header("Location: ../View/admin/admin.php");
            exit();
        }else{
            header("Location: ../View/oups.php");
            exit();
        }
    }
    
    if(isset($_POST["register"])&&!empty($_POST["register"])){
        if(isset($_POST["Name"])&&isset($_POST["CIN"])&&isset($_POST["dateOfBirth"])
        &&isset($_POST["Email"])&&isset($_POST["username"])&&isset($_POST["password"])&&isset($_POST["Rpassword"])){
            if(!empty($_POST["Name"])&&!empty($_POST["CIN"])&&!empty($_POST["dateOfBirth"])
        &&!empty($_POST["Email"])&&!empty($_POST["username"])&&!empty($_POST["password"])){
            $login = $_POST["username"];
            $password = $_POST["password"];
            $nom = $_POST["Name"];
            $cin = $_POST["CIN"];
            $date_naiss = $_POST["dateOfBirth"];
            $email = $_POST["Email"];
            if(Utilisateur::createUser($login,$password,$nom,$cin,$date_naiss,$email)){
                session_start();
                $_SESSION['username'] = $_POST["username"];
                $_SESSION["role"]=0;
                header("Location: ../");
                exit();
            }else{
                header("Location: ../View/oups.php");
                exit();
            }
        }
    }   
}
if(isset($_GET["logout"])){
    session_start();
    session_destroy();
    echo"text";
    header("Location: ../View/login.php");
    exit();
}
