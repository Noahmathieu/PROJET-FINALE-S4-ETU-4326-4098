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
<h1>Bienvenue a Vous</h1>
<h2>Votre Solde c'est<?=  ?></h2>


</body>
</html>