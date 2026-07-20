<?php
ob_start();
?>
<div class="stack-grid">
    <section class="panel-card">
        <div class="panel-head">
            <div>
                <h3>Acces rapides</h3>
                <p>Les entrees principales pour gerer les regles du reseau et superviser l'activite.</p>
            </div>
        </div>

        <div class="inline-actions">
            <a class="action-chip" href="<?= base_url('config'); ?>">Configuration</a>
            <a class="action-chip" href="<?= base_url('frais'); ?>">Frais</a>
            <a class="action-chip" href="<?= base_url('typeOperation'); ?>">Types d'operation</a>
            <a class="action-chip" href="<?= base_url('situationClient'); ?>">Comptes clients</a>
        </div>
    </section>
</div>
<?php
$content = ob_get_clean();

echo view('operateur/_layout', [
    'title' => 'Dashboard operateur',
    'pageHeading' => 'Dashboard operateur',
    'pageDescription' => "Vue d'ensemble des gains et acces rapides aux modules de configuration.",
    'activeMenu' => 'dashboard',
    'summaryCards' => [
        ['label' => 'Gains Autre Operateur', 'value' => $beneficeOperateur['commission'] ?? 0, 'note' => 'Gains autres operateurs', 'tone' => 'tone-blue'],
        ['label' => 'Benefice Operateur', 'value' => $benefice ?? 0, 'note' => 'Gains operateurs', 'tone' => 'tone-blue'],
        ['label' => 'Retraits', 'value' => $retrait ?? 0, 'note' => 'Frais lies aux retraits', 'tone' => 'tone-indigo'],
        ['label' => 'Transferts', 'value' => $transfert ?? 0, 'note' => 'Frais lies aux transferts', 'tone' => 'tone-navy'],
    ],
    'content' => $content,
]);
