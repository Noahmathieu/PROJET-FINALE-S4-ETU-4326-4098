<!-- erreur dans la authcontroller s'affiche ici -->
<?php
    $error = session()->getFlashdata('error');
    if ($error) {
        echo '<p style="color: red;">' . $error . '</p>';
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Connexion</h1>
    <form action="<?php echo base_url('/checkLogin'); ?>" method="post" enctype="multipart/form-data">
        <p>Entrez votre numero: <input type="tel" name="numero" id="numero" required></p>
        <input type="submit" value="Se connecter">
    </form>

</body>
</html>