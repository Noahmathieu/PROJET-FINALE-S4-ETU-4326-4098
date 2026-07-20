<?php
$clients = $clients ?? [];

ob_start();
?>
<section class="table-card">
    <div class="section-head">
        <div>
            <h3>Situation des comptes clients</h3>
            <p>Surveillez les numeros et les soldes depuis un tableau clair et filtrable.</p>
        </div>
    </div>

    <div class="search-row">
        <input class="search-field" type="search" data-grid-search="#clientTable" placeholder="Rechercher un client ou un solde">
    </div>

    <div class="table-wrap">
        <table class="operator-table" id="clientTable">
            <thead>
                <tr>
                    <th>Numero</th>
                    <th>Solde</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($clients)): ?>
                    <tr>
                        <td colspan="3">
                            <div class="empty-state">
                                <strong>Aucun compte client disponible.</strong>
                                <span>Les comptes apparaissent ici des qu'un client a effectue une connexion ou une operation.</span>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>

                <?php foreach ($clients as $client): ?>
                    <tr data-search-item>
                        <td><?= esc($client['numero']) ?></td>
                        <td><?= number_format((float) $client['solde'], 0, ',', ' ') ?> Ar</td>
                        <td>
                            <div class="table-actions">
                                <a class="action-chip" href="<?= base_url('historique/' . $client['id']) ?>">Historique</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>
<?php
$content = ob_get_clean();

echo view('operateur/_layout', [
    'title' => 'Situation des comptes clients',
    'pageHeading' => 'Situation des comptes clients',
    'pageDescription' => 'Visualisez les soldes clients et accedez rapidement a leur historique.',
    'activeMenu' => 'situationCompte',
    'content' => $content,
]);