<!-- // apprendre_hashage -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>S'inscrire</h1>
    <form action="traitement.php?action=register" method="post">
        <label for="">Pseudo</label>
        <input type="text" name="pseudo"><br>

        <label for="">Mail</label>
        <input type="email" name="email"><br>

        <label for="">Mot de passe</label>
        <input type="password" name="pass1"><br>

        <label for="">Confirmation de mot de passe</label>
        <input type="password" name="pass2"><br>

        <input type="submit" value="S'enregistrer">
    </form>
</body>
</html>