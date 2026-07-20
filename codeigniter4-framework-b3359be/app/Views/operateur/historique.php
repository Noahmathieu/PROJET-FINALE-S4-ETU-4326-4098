<?php
$historiques = $historiques ?? [];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique des opérations</title>
</head>
<body>
    <h1>Historique des opérations d'un client</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Type d'opération</th>
                <th>Montant</th>
                <th>Date</th>
                <th>Destinataire</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($historiques as $historique): ?>
                <tr>
                    <td><?= htmlspecialchars($historique['typeOperationNom'] ?? $historique['type_operation_id']) ?></td>
                    <td><?= htmlspecialchars($historique['montant']) ?></td>
                    <td><?= htmlspecialchars($historique['date_operation']) ?></td>
                    <td><?= htmlspecialchars($historique['destinataire'] ?? '-') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>