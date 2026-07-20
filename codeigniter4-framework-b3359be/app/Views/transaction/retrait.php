<?php
$error = session()->getFlashdata('error');
if ($error) {
    echo '<p style="color: red;">' . $error . '</p>';
}
if ($success = session()->getFlashdata('success')) {
    echo '<p style="color: #00f620;">' . $success . '</p>';
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
    <h2>Retrait</h2>
    <form action="<?= base_url('transfert/retrait/valide'); ?>" method="post" enctype="multipart/form-data">
        <p>Entrez le montant à retirer: <input type="number" name="montant" id="montant" required></p>
        <input type="submit" value="Retirer">
    </form>

</body>
</html>