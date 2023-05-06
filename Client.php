<?php
if(isset($_POST['Valider'])){
    //echo "Ok";
    // include('accueil.php');
    if(!empty($_POST['Nom']) and !empty($_POST['Prenom']) and !empty($_POST['Contact']) and !empty($_POST['Numapp'])){
        //echo 'Connection établir';
        $Nom = $_POST['Nom'];
        $Prenom = $_POST['Prenom'];
        $Contact = $_POST['Contact'];
        $Numapp = $_POST['Numapp'];

        //echo $Nom;echo $Prenom;echo $Contact;
        $pdo = new pdo('mysql:host=localhost;dbname=gestion_immobilier', 'root', '');

        $insertion = $pdo->prepare('insert into client(Nom,Prenom,Contact,Num_app) values(?,?,?,?)');
        
        //insertion des champs du formulaire dans la base de donnée

        $insertion->execute(array($Nom,$Prenom,$Contact,$Numapp));
    }
    else{
        echo 'Veuillez remplir les champs';
    }
}
else{
    // echo "Le bouton n'existe pas";
}
$pdo = new pdo('mysql:host=localhost;dbname=gestion_immobilier', 'root', '');
?>







<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client</title>
    <link rel="stylesheet" href="./Client.css">
<style>
    body{
        text-align: center;
    }
</style>
</head>
<body>
    
    <form action="" method="Post">
        <fieldset>
            <legend>Authentification</legend>
            <label for="Nom" class="label">Nom</label><br>
            <input type="text" name="Nom" id="" maxlength="20" class="forme"><br>
            <label for="Prenom" class="label">Prenom</label><br>
            <input type="text" name="Prenom" id="" class="forme"><br>
            <label for="Contact" class="label">Contact</label><br>
            <input type="text" name="Contact" id="" class="forme"><br>
            <label for="Num_app" class="label">Numero appartement</label><br>
            <input type="number" name="Numapp" id="" class="forme"><br><br><br>
            <input type="submit" name="Valider" id="" value="Valider" class="Va">
            <input type="reset" name="Annuler" id="" value="Annuler" class="An">
        </fieldset>
    </form>
</body>
</html>