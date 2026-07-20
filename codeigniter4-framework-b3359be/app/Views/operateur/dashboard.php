<?php
$benefice = $benefice['frais'] ?? 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <h1>Bienvenue a Vous</h1>
    <h2>Dashboard</h2>
    <ul>
        <li><a href="<?= base_url('config'); ?>">Configuration</a></li>
        <li><a href="<?= base_url('frais'); ?>">Frais</a></li>
        <li><a href="<?= base_url('typeOperation'); ?>">Type d'Opération</a></li>
    </ul>
<h2>Benefice: <?= $benefice ?></h2>
</body>
</html>
