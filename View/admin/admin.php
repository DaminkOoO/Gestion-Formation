<?php
session_start();
if(!isset($_SESSION['username']))
    header("Location: ../login.php");
if($_SESSION["role"]==0)
    header("location: ../../index.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Training</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
    table{
        background-color: #0D0C0D;
        border-radius: 23px;
    }
    .container-index{
        height: 100%;
        position: relative;
        top:100px;
    }
    h1{
        margin-bottom: 25px;
    }
    table {
	border-collapse: collapse;
	width: 100%;
    }

    th, td {
        text-transform: capitalize;
        text-align: center;
        padding: 20px;
        color:white;
        font-weight: 600;
    }

    th {
        background-color:  #988775;
        color: white;
    }
    a {
        text-decoration: none;
        color: #1E90FF;
    }
    .navbar>a{
        margin-left: 30px;
    }

    </style>
</head>
<body class="container">
     <div class="navbar">
            <a href="../../index.php">
                <svg width="100" height="69" viewBox="0 0 65 69" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M32.5 0C14.5489 0 0 14.6007 0 32.6156H65C65 14.6007 50.4451 0 32.5 0Z" fill="#DDC3A5"/>
                    <path d="M61.4421 36.3906C61.4421 52.4099 48.4565 65.4357 32.5 65.4357C16.5375 65.4357 3.55787 52.4039 3.55787 36.3906H0C0 54.3755 14.5789 69.0062 32.5 69.0062C50.4211 69.0062 65 54.3755 65 36.3906H61.4421Z" fill="#DDC3A5"/>
                    <path d="M32.5 60.8371C45.9348 60.8371 56.866 49.8671 56.866 36.3844H53.3081C53.3081 47.9015 43.9702 57.2666 32.5 57.2666C21.0238 57.2666 11.6919 47.8955 11.6919 36.3844H8.13997C8.13398 49.8731 19.0651 60.8371 32.5 60.8371Z" fill="#DDC3A5"/>
                </svg>
            </a>
            <?php if ($_SESSION["role"] == 1): ?>
            <a href='../../index.php'>Home</a>
            <?php endif; ?>
            
            <a href="Controller/utilisateurController.php?logout=log">Logout</a>
        </div>
        <div class="container-index">
    <table>
        <tr>
            <th>The training</th>
            <th>Total number of seats</th>
            <th>Number of confirmed reservations</th>
            <th>Number of pending reservations</th>
            
        </tr>
        <?php
        include("../../Model/formationModel.php");
        $listeDesFormations=Formation::getAllFormation();
        foreach ($listeDesFormations as $formation) {
            echo $formation;
        }
        ?>
    </table>
    <h3 stlye="position:relative;top:300px;"><a href="ajoutFormation.php">Add Training</a></h3>

    </div>
      
</body>
</html>