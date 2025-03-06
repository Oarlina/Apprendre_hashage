<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
    var_dump ($_SESSION);
    if (isset($_SESSION["user"])){
        echo "<a href='traitement.php?action=logout'>Se déconnecter</a>";
    }else {
        echo "<a href='login.php'>se connecter</a> <br>";
        echo"<a href='register.php'>s'inscrire</a>";
    } ?>
<h1>Acceuil</h1>
<a href="index.php">index</a>
<?php if(isset($_SESSION["user"])){ 
    echo "Bienvenue ". $_SESSION["user"]["pseudo"];
    echo" <a href='profil.php'> Mon compte</a>";
} ?>

<!-- faire log out avec navigateur
    inspecter/ appli (sur chrome) / cookie/ et on peut supprimer le cookie -->
</body>
</html>