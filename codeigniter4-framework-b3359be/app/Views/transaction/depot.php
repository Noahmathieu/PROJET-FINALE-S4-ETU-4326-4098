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
            <h3>Depot</h3>
            <p>Ajoutez du solde en quelques secondes.</p>
        </div>
    </div>

    <form class="form-grid" action="<?= base_url('transfert/depot/valide'); ?>" method="post">
        <div class="form-group">
            <label for="montant">Montant a deposer</label>
            <input type="number" name="montant" id="montant" min="1" step="0.01" required>
        </div>

        <button class="primary-button" type="submit">Déposer</button>
    </form>
</section>
<?php
$content = ob_get_clean();

echo view('client/_layout', [
    'title' => 'Depot',
    'pageHeading' => 'Depot',
    'pageDescription' => 'Alimentez votre compte avec une saisie simple et rapide.',
    'activeMenu' => 'depot',
    'clientName' => $clientName ?? 'Client',
    'soldeValue' => $soldeValue ?? 0,
    'content' => $content,
]);