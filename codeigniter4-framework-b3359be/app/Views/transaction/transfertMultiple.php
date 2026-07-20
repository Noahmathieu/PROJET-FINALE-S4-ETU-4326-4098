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
            <h3>Transfert Multiple</h3>
            <p>Envoyez de l'argent vers un ou plusieurs numéros valides autorisés.</p>
        </div>
    </div>
    <form class="form-grid" action="<?= base_url('transfertMultiple/valide'); ?>" method="post">
        <div id="destinatairesContainer">
            <div class="form-group destinataire-row">
                <label for="destinataire_1">Numéro du destinataire 1</label>
                <div style="display: flex; gap: 10px;">
                    <input type="tel" name="destinataires[]" id="destinataire_1" inputmode="tel" required placeholder="Ex: 0340000000">
                </div>
            </div>
        </div>

        <button type="button" id="ajouterDestinataire" style="margin-bottom: 15px;">+ Ajouter un destinataire</button>

        <div class="form-group">
            <label for="montant">Montant total à transférer</label>
            <input type="number" name="montant" id="montant" min="1" step="0.01" required placeholder="0.00">
        </div>

        <button class="primary-button" type="submit">Transférer</button>
    </form>

    <script>
        document.getElementById('ajouterDestinataire').addEventListener('click', function() {
            const container = document.getElementById('destinatairesContainer');
            const count = container.querySelectorAll('.destinataire-row').length + 1;

            const newInputRow = document.createElement('div');
            newInputRow.classList.add('form-group', 'destinataire-row');
            newInputRow.style.marginTop = '10px';
            
            newInputRow.innerHTML = `
                <label>Numéro du destinataire ${count}</label>
                <div style="display: flex; gap: 10px;">
                    <input type="tel" name="destinataires[]" inputmode="tel" required placeholder="Ex: 0340000000">
                    <button type="button" class="btn-remove" onclick="removeDestinataire(this)">Supprimer</button>
                </div>
            `;
            
            container.appendChild(newInputRow);
        });

        function removeDestinataire(button) {
            button.closest('.destinataire-row').remove();
        }
    </script>

</section>
<?php
$content = ob_get_clean();

echo view('client/_layout', [
    'title' => 'Transfert Multiple',
    'pageHeading' => 'Transfert Multiple',
    'pageDescription' => 'Transmettez des fonds vers plusieurs destinataires du même opérateur.',
    'activeMenu' => 'transfertMultiple',
    'clientName' => $clientName ?? 'Client',
    'soldeValue' => $soldeValue ?? 0,
    'content' => $content,
]);