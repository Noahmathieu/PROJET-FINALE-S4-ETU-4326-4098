<?php
$historiques = $historiques ?? [];

ob_start();
?>
<section class="table-card">
    <div class="section-head">
        <div>
            <h3>Historique des operations</h3>
            <p>Consultez les depots, retraits et transferts du client selectionne.</p>
        </div>
    </div>

    <div class="search-row">
        <input class="search-field" type="search" data-grid-search="#historyTable" placeholder="Filtrer par type, montant ou destinataire">
    </div>

    <div class="table-wrap">
        <table class="operator-table" id="historyTable">
            <thead>
                <tr>
                    <th>Type d'operation</th>
                    <th>Montant</th>
                    <th>Date</th>
                    <th>Destinataire</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($historiques)): ?>
                    <tr>
                        <td colspan="4">
                            <div class="empty-state">
                                <strong>Aucune operation trouvee.</strong>
                                <span>Ce client n'a pas encore d'historique disponible.</span>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>

                <?php foreach ($historiques as $historique): ?>
                    <tr data-search-item>
                        <td><?= esc($historique['typeOperationNom'] ?? $historique['type_operation_id']) ?></td>
                        <td><?= number_format((float) $historique['montant'], 0, ',', ' ') ?> Ar</td>
                        <td><?= esc($historique['date_operation']) ?></td>
                        <td><?= esc($historique['destinataire'] ?? '-') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>
<?php
$content = ob_get_clean();

echo view('operateur/_layout', [
    'title' => 'Historique des operations',
    'pageHeading' => 'Historique des operations',
    'pageDescription' => 'Suivi detaille des operations du client avec recherche instantanee.',
    'activeMenu' => 'situationCompte',
    'content' => $content,
]);