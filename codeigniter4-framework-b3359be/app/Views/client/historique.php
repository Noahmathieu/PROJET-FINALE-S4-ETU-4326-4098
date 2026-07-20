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
    <h2>Historique</h2>
    <table>
        <thead>
            <tr>
                <th>Type d'opération</th>
                <th>Montant</th>
                <th>Frais</th>
                <th>Date</th>
                <th>Destinataire</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($transactions as $transaction) : ?>
                <tr>
                    <td><?= $transaction['type_operation'] ?></td>
                    <td><?= number_format($transaction['montant'], 2) ?> Ar</td>
                    <td><?= number_format($transaction['frais'], 2) ?> Ar</td>
                    <td><?= $transaction['date_operation'] ?></td>
                    <td><?= $transaction['destinataire'] ?? 'N/A' ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>