<?php
$error = session()->getFlashdata('error');
$success = session()->getFlashdata('success');
$prefixesOperateur = array_values(array_filter(array_map(
    static fn (array $config): string => ltrim((string) ($config['prefixe'] ?? ''), '0'),
    $prefixesOperateur ?? []
)));

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
            <h3>Transfert</h3>
            <p>Envoyez de l'argent vers un numero valide autorise.</p>
        </div>
    </div>

    <form class="form-grid" action="<?= base_url('transfert/valide'); ?>" method="post">
        <div class="form-group">
            <label for="destinataire">Numero du destinataire</label>
            <input type="tel" name="destinataire" id="destinataire" inputmode="tel" required>
        </div>

        <div class="form-group">
            <label for="montant">Montant a transferer</label>
            <input type="number" name="montant" id="montant" min="1" step="0.01" required>
        </div>

        <label class="form-check">
            <input type="checkbox" name="inclure_frais_retrait" id="inclure_frais_retrait" value="1">
            <span>Inclure les frais de retrait pour le destinataire</span>
        </label>
        <p id="retrait-externe-info" class="form-hint" hidden>
            Les frais de retrait ne s'appliquent pas aux autres opérateurs.
        </p>

        <button class="primary-button" type="submit">Transferer</button>
    </form>
</section>
<script>
    (() => {
        const prefixesOperateur = <?= json_encode($prefixesOperateur, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>;
        const numeroInput = document.getElementById('destinataire');
        const fraisRetraitInput = document.getElementById('inclure_frais_retrait');
        const infoExterne = document.getElementById('retrait-externe-info');

        const actualiserFraisRetrait = () => {
            let numero = numeroInput.value.replace(/\D/g, '');

            if (numero.startsWith('261')) {
                numero = `0${numero.slice(3)}`;
            }

            const estMemeOperateur = prefixesOperateur.includes(numero.slice(1, 3));
            const estNumeroComplet = /^0\d{9}$/.test(numero);
            const estExterne = estNumeroComplet && !estMemeOperateur;

            fraisRetraitInput.disabled = estExterne;
            if (estExterne) {
                fraisRetraitInput.checked = false;
            }
            infoExterne.hidden = !estExterne;
        };

        numeroInput.addEventListener('input', actualiserFraisRetrait);
        actualiserFraisRetrait();
    })();
</script>
<?php
$content = ob_get_clean();

echo view('client/_layout', [
    'title' => 'Transfert',
    'pageHeading' => 'Transfert',
    'pageDescription' => 'Transmettez des fonds avec controle du numero destinataire.',
    'activeMenu' => 'transfert',
    'clientName' => $clientName ?? 'Client',
    'soldeValue' => $soldeValue ?? 0,
    'content' => $content,
]);
