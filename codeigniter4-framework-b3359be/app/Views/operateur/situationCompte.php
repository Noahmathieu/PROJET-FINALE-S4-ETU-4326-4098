<?php
$clients = $clients ?? [];
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Situation des comptes clients</title>
</head>

<body>
    <h1>Situation des comptes clients</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Numero</th>
                <th>Solde</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clients as $client): ?>
                <tr>
                    <td><?= htmlspecialchars($client['numero']) ?></td>
                    <td><?= htmlspecialchars($client['solde']) ?></td>
                    <td>
                        <a href="<?= base_url('historique/' . $client['id']) ?>">Historique</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>