<?php

if(isset($_GET['action'])){
    switch ($_GET['action']){
        case "register":
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
        break;
    }
}