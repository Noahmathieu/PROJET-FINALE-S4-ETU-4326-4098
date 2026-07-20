<?php
$error = session()->getFlashdata('error');
$success = session()->getFlashdata('success');
$soldeValue = $soldeValue ?? 0;

ob_start();
?>
<?php if ($error): ?>
    <div class="flash-message error" role="alert"><?= esc($error) ?></div>
<?php endif; ?>

<?php if ($success): ?>
    <div class="flash-message success" role="status"><?= esc($success) ?></div>
<?php endif; ?>

<section class="client-table-card">
    <div class="panel-head">
        <div>
            <h3>Historique des operations</h3>
            <p>Filtre visuel et lecture rapide de vos mouvements recents.</p>
        </div>
    </div>

    <?php if (empty($transactions)): ?>
        <div class="empty-state">
            <strong>Aucune transaction trouvee.</strong>
            <span>Effectuez une operation pour voir apparaître votre historique ici.</span>
        </div>
    <?php else: ?>
        <div class="table-wrap">
            <table class="operator-table client-table">
                <thead>
                    <tr>
                        <th>Type d'operation</th>
                        <th>Montant</th>
                        <th>Frais</th>
                        <th>Date</th>
                        <th>Destinataire</th>
                        <th>Commission</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($transactions as $transaction): ?>
                        <tr>
                            <td><?= esc($transaction['nomType']) ?></td>
                            <td><?= number_format((float) $transaction['montant'], 0, ',', ' ') ?> Ar</td>
                            <td><?= number_format((float) $transaction['frais'], 0, ',', ' ') ?> Ar</td>
                            <td><?= esc(date('Y-m-d H:i:s', strtotime($transaction['date_operation']))) ?></td>
                            <td><?= esc($transaction['destinataire'] ?? 'N/A') ?></td>
                            <td><?= number_format((float) $transaction['commission'], 0, ',', ' ') ?> Ar</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</section>
<?php
$content = ob_get_clean();

echo view('client/_layout', [
    'title' => 'Historique client',
    'pageHeading' => 'Historique',
    'pageDescription' => 'Retrouvez les operations effectuees sur votre compte.',
    'activeMenu' => 'historique',
    'clientName' => session()->get('client_id') ?: 'Client',
    'soldeValue' => $soldeValue,
    'content' => $content,
]);