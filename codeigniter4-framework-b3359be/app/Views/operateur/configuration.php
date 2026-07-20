<?php
$prefixe = $prefixe ?? [];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Configuration Form</h1>

    <form action="<?= base_url('config/ajouter') ?>" method="post">
        <input type="text" name="prefixe" placeholder="Enter prefixe">
        <button type="submit">Ajouter</button>
    </form>

    <?php foreach ($prefixe as $config): ?>
    <ul>
        <li>Prefixe: <?= $config['prefixe'] ?></li>
        <a href="<?= base_url('config/supprimer/'. $config['id']) ?>">Supprimer</a>
    </ul>
    <?php endforeach; ?>
</body>

</html>