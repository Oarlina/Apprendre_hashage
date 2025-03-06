<?php

session_start();

if(isset($_GET['action'])){
    switch ($_GET['action']){
        case "register":
            if (!isset($_POST['submit'])) {
                header("Location: register.php");
              }
            // on cree la pdo 
            $pdo = new PDO("mysql:host=localhost;dbname=apprendre_hashage;charset=utf8", "root","");

            // on instancie les elements et les filtre
            $pseudo = filter_input(INPUT_POST, "pseudo", FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS, FILTER_VALIDATE_EMAIL);
            $pass1 = filter_input(INPUT_POST, "pass1", FILTER_SANITIZE_SPECIAL_CHARS);
            $pass2 = filter_input(INPUT_POST, "pass2", FILTER_SANITIZE_SPECIAL_CHARS);

            // on verifie s'il son vide
            if($pseudo && $email && $pass1 && $pass2){
                // var_dump("ok"); 

                // on verifie que le mail n'existe pas déjà
                $requete = $pdo->prepare("SELECT * FROM user WHERE email = :email");
                $requete->execute(["email" => $email]);
                $user = $requete->fetch();
                if ($user){
                    header("Location: register.php");
                }
                // var_dump("Utilisateur inexistant");

                // on insert l'utilisateur en BDD
                if ($pass1 == $pass2 && strlen($pass1)>=5){ // normalement il doit etre au moins a 12 caracteres avec majuscule et caractere speciaux
                    $insertUser = $pdo->prepare ("INSERT INTO user (pseudo, email, password)
                                                 VALUES (:pseudo, :email, :password)");
                    $insertUser->execute([
                        "pseudo" => $pseudo,
                        "email" => $email,
                        "password" => password_hash($pass1,PASSWORD_DEFAULT)
                    ]);
                    header ("Location: login.php");
                }
                echo "Un des champs est invalide, recommencez !<br> <a href='register.php'>S'inscrire</a>";
            }
            // on envoie sur la page de connexion si l'inscription est valider
            header ("Location: register.php");
        break;

        case "login":
            if ($_POST['submit']) {
              header("Location: login.php");
            }
            $pdo = new PDO("mysql:host=localhost;dbname=apprendre_hashage;charset=utf8", "root","");

            // on instancie les elements et les filtre
            $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS, FILTER_VALIDATE_EMAIL);
            $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

            if($email && $password){
                // var_dump("ok");
                $requete = $pdo->prepare("SELECT *FROM user WHERE email =:email");
                $requete->execute(["email" => $email]);
                $user = $requete->fetch();
                // var_dump($user);

                if ($user){
                    $hash = $user["password"];
                    if (password_verify($password, $hash)){ // si le mot de passe d'inscription est le meme que celui de connexion, il compare les empreinte numerique
                        $_SESSION["user"] = $user; // on lance la session d'un utilisateur dans session
                        header("Location: home.php");
                    }else{
                        header("Location: login.php");
                    }
                }
                header("Location: home.php");
            }
            // header("Location: login.php");
        break;

        case "Logout":

        break;

        case "home":
            header("Location: home.php");
            break;
    }
}