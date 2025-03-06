<?php

$password = "monMotdePasse1234";
/* 
    Si deux personnes ont le même mot de passe ils auront le même string. 
    La valeur ne change pas mlgré les réfresh
    c'est un algorithme de hachage faible
*/
$md5 = hash('md5', $password); // on hash (on dit qu'elle méthode on veut, puis la chaine de caratere a hasher)
/* 
    La chaine de caractère est plus longues mais elle ne change toujours pas malgré les refresh de la page
    c'est un algorithme de hachage faible
*/
$sha256 = hash('sha256', $password);

/* 
    on enregistre l'empreinte numérique soit tous sa:
    $2y$10$6z7CKa9kpDN7KC3ICW1Hi.fd0/to7Y/x36WUKNPOIndHdkdR9Ae3K

    algorithm : $2y$
    algorithm options (eg cost) : 10$ (c'est le cout)
    Salt : 6z7CKa9kpDN7KC3ICW1Hi. (le point ici est aléatoire)
    la partie hasher :(ici : fd0/to7Y/x36WUKNPOIndHdkdR9Ae3K)
*/
/* 
    password_hash(..., PASSWORD_DEFAULT) est concu pour s'ameliorer
    il faut laisser 255caractere possible
    quand le mot de passe est hasher on ne peut plus jamais le retrouver
    il renvoie un string
    le salt et le hashage change a chaque refresh
    si le mot de passe est similaire : les chaines seront diffenrentes (cela permet d'avoir deux utilisateurs qui ont le meme mdp tout en etant securiser)
*/
$hash = password_hash($password, PASSWORD_DEFAULT);
/* 
    on a des paramètres en plus 
    exemple : $argon2i$v=19$m=65536,t=4,p=1$c0NTc01qQmZ2Q0Vxakc4cA$Xa/a2gbfzklca63ENzCTfzzqxeikuFNIEca9QA6EN7k
    change a chauqe fois
*/
$hash2 = password_hash($password, PASSWORD_ARGON2I);
$hash2 = password_hash($password, PASSWORD_BCRYPT);

echo $hash."<br>";
echo $hash2;



//saisie dans le formulaire de login
$saisie = "monMotdePasse1234";

$check = password_verify($saisie, $hash); // permet de renvoyer un boolen il compare les empreintes numériques

$user="Rachel";

if (password_verify($saisie, $hash)){
    echo $user. "est connecté";
}else{
    echo "Les mots de passe sont différents! ";
}

var_dump($check);
