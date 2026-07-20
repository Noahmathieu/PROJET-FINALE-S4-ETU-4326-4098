<?php
$error = session()->getFlashdata('error');
$success = session()->getFlashdata('success');

ob_start();
?>
<?php if ($error): ?>
    <div class="flash-message error" role="alert"><?= esc($error) ?></div>
<?php endif; ?>

<?php if ($success): ?>
    <div class="flash-message success" role="status"><?= esc($success) ?></div>
<?php endif; ?>

<section class="client-form-card">
    <div class="panel-head">
        <div>
            <h3>Retrait</h3>
            <p>Retirez du solde tout en gardant la lisibilite des frais.</p>
        </div>
    </div>

    <form class="form-grid" action="<?= base_url('transfert/retrait/valide'); ?>" method="post">
        <div class="form-group">
            <label for="montant">Montant a retirer</label>
            <input type="number" name="montant" id="montant" min="1" step="0.01" required>
        </div>

        <button class="primary-button" type="submit">Retirer</button>
    </form>
</section>
<?php
$content = ob_get_clean();

echo view('client/_layout', [
    'title' => 'Retrait',
    'pageHeading' => 'Retrait',
    'pageDescription' => 'Controlez le montant et les frais avant validation.',
    'activeMenu' => 'retrait',
    'clientName' => $clientName ?? 'Client',
    'soldeValue' => $soldeValue ?? 0,
    'content' => $content,
]);