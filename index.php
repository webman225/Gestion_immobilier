<?php
    session_start();
    $bd = new pdo('mysql:host=localhost;dbname=gestion_immobilier', 'root', '');
    if(isset($_POST['submit'])){
        if(!empty($_POST['email']) AND !empty($_POST['mdp'])){
            $email = $_POST['email'];
            $mdp = $_POST['mdp'];

            $recupuser = $bd->prepare('SELECT * FROM logins where email = ? AND mdp = ?');
            $recupuser->execute(array($email, $mdp));
            if($recupuser->rowCount() > 0){
                $_SESSION['email'] = $email;
                $_SESSION['mdp'] = $mdp;
                $_SESSION['name'] = $Name;
                header('Location: accueil.php');
                exit;
            }else{
                echo 'le mot de passe ou le pseudo est incorrect...';
            }
        }else{
            // echo "Veuillez remplir tous les champ.....";
            echo '<script> 
        window.location.href="index.php";
        alert("Connection Echoué. Nom utilisateur et mot de passe invalide")
        </script>';
        // header('location:login.php');
        // exit;
        }
    }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/connexion.css">
    <link rel="stylesheet" href="css/bootsrap.min.css">
    <link rel="stylesheet" href="css/all.css">
    <title>Login</title>
</head>
<body>
    <form action="" method="post">
        <h1>Se connecter</h1>
        <div class="media">
            <p><a href=""><i class="fa-brands fa-google"></i></a></p>
            <p><a href=""><i class="fa-brands fa-instagram"></a></i></p>
            <p><a href=""><i class="fa-brands fa-facebook"></i></a></p>
            <p><a href=""><i class="fa-brands fa-twitter"></i></a></p>
        </div>
        <p class="use-email">Ou utiliser mon adresse email:</p>
        <div class="input">
            <input name="email" type="email" placeholder="Email" required autocomplete="off">
            <input name="mdp" type="password" placeholder="Mot de passe" required autocomplete="off">
        </div>
        <p class="incription">je n'ai pas de <span>compte</span>. je m'en <a href="inscription.php" class="new">crée</a> un.</p>
        
        <div align="center">
        <span class="psw" ><a href="email_check.php">Mot de passe oublié ?</a></span><br><br>
            <button name="submit" type="submit">Se connecter</button>
        </div>
    </form>
</body>
</html>