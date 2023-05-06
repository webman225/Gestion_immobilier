<?php
session_start();
$pdo = new pdo('mysql:host=localhost;dbname=gestion_immobilier', 'root', '');
// Verification de la variable
if(!empty($_POST)){
    extract($_POST);
    $valid = true;

    if(isset($_POST['Submit'])){
        $Name = $_POST['name'];
        $Contact = $_POST['contact'];
        $Email = $_POST['email'];
        $Pwd = $_POST['pwd'];
        $Pwdc = $_POST['pwdc'];

        if(empty($Name)){
            $valid = false;
        }
        if(empty($Contact)){
            $valid = false;
        }
        if(empty($Email)){
            $valid = false;

            //verifier que le format du mail est verifier
        } elseif(!preg_match("/^[a-z0-9\]+@[a-z]+\.[a-z]{2,3}$/i", $Email)){
            $valid = false;
        }
        else{
            //verifie que le mail est disponible
            $er_email = $pdo->prepare('SELECT email FROM logins where email = ?');
            $er_email->execute(array($Email));
            $er_email = $er_email->fetch();

            if($er_email['email'] <> ""){
                $valid = false;
                $er_email = ("Ce mail existe deja");
            }
        }
        //verification mot de passe
        if(empty($Pwd)){
            $valid = false;    
        }
        elseif($Pwd != $Pwdc){
            $valid = false;
            $er_Pwd = ("Le mot de passe de confirmation est incorrect");
        }
    }

    //Si Toute les condition sont remplis alors on fait le traitement
    if($valid){
        $insertuser = $pdo->prepare('INSERT INTO logins(user_name,contact,email,mdp) values(?,?,?,?)');
        $insertuser->execute(array($Name, $Contact, $Email, $Pwd));

        $recupuser = $pdo->prepare('SELECT * FROM logins where email = ? AND mdp = ?');
        $recupuser->execute(array($Email, $Pwd));

        if($recupuser->rowCount() > 0){
            $_SESSION['email'] = $Email;
            $_SESSION['pwd'] = $mdp;

            header('Location: accueil.php');
                exit;
        }
    }
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="./acces/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/inscription.css">
    <link rel="stylesheet" href="./css/all.css">
</head>
<body>
    <form action="" method="post">
        <h1>Create Account</h1>
        <div class="titre">
    
        <label for="name" class="">User Name</label><br>
        <input type="text" name="name" autocomplete="off" class="" placeholder="Nom d'utilisateur..." value="<?php if(isset($Name)){echo $Name;}?>" required><br>
        <label for="name" class="">Contact</label><br>
        <input type="text" autocomplete="off" name="contact" class="" placeholder="Contact..." value="<?php if(isset($Contact)){echo $Contact;}?>" required><br>
        <?php if(isset($er_email)){
            echo $er_email;
        }
        ?><br>
        <label for="email" class="">Email</label><br>
        <input type="email" autocomplete="off" name="email" class="" placeholder="Email..." value="<?php if(isset($Email)){echo $Email;}?>" required><br>
        <label for="pwd">Password</label><br>
        <input type="password" autocomplete="off" name="pwd" maxlength="20" class="" placeholder="Mot de passe..." value="<?php if(isset($Pwd)){echo $Pwd;}?>" required><br>
        <?php if(isset($er_Pwd)){
            echo $er_Pwd;
        }
        ?><br>
        <label for="pwd">Password Check</label><br>
        <input type="password" maxlength="20" name="pwdc" class="" autocomplete="off" placeholder="Mot de passe..." value="<?php if(isset($Pwdc)){echo $Pwdc;}?>" required><br>
        <input type="submit" class="input" value="Submit" name="Submit">

    </div>
    </form>
</body>
</html>
