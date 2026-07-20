<?php
$error = session()->getFlashdata('error');
if ($error) {
    echo '<p style="color: red;">' . $error . '</p>';
}
if ($success = session()->getFlashdata('success')) {
    echo '<p style="color: #00f620;">' . $error . '</p>';
}
$solde = $clients['solde'] ?? 0;
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
    <h2>Votre Solde c'est <?= number_format($solde, 2) ?> Ar</h2>
    <form action="<?php echo base_url('/client/depot'); ?>" method="get">
        <button type="submit">Depot</button>
    </form>
    <form action="<?php echo base_url('/client/retrait'); ?>" method="get">
        <button type="submit">Retrait</button>
    </form>
    <form action="<?php echo base_url('/client/transfert'); ?>" method="get">
        <button type="submit">Transfert</button>
    </form>
    <form action="<?php echo base_url('/client/historique'); ?>" method="get">
        <button type="submit">Voir Historique</button>
    </form>
    

</body>
</html>