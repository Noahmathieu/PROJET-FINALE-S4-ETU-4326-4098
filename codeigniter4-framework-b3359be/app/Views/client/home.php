<?php
$error = session()->getFlashdata('error');
$success = session()->getFlashdata('success');
$solde = $clients['solde'] ?? 0;
$numero = $clients['numero'] ?? '';

ob_start();
?>
<?php if ($error): ?>
    <div class="flash-message error" role="alert"><?= esc($error) ?></div>
<?php endif; ?>

<?php if ($success): ?>
    <div class="flash-message success" role="status"><?= esc($success) ?></div>
<?php endif; ?>

<div class="client-dashboard-grid">
    <article class="client-stat-card accent-blue">
        <span>Solde disponible</span>
        <strong><?= number_format((float) $solde, 0, ',', ' ') ?> Ar</strong>
        <p>Votre montant actuel est affiche en temps reel.</p>
    </article>

    <article class="client-stat-card accent-cyan">
        <span>Numero</span>
        <strong><?= esc($numero) ?></strong>
        <p>Identifiant de connexion pour vos operations.</p>
    </article>

    <article class="client-stat-card accent-indigo">
        <span>Etat</span>
        <strong>Actif</strong>
        <p>Vos services de depot, retrait et transfert sont disponibles.</p>
    </article>
</div>

<div class="client-actions-grid">
    <a class="client-action-card" href="<?= base_url('/client/depot'); ?>">
        <span>Depot</span>
        <strong>Ajouter du solde</strong>
        <p>Alimentez votre compte rapidement.</p>
    </a>

    <a class="client-action-card" href="<?= base_url('/client/retrait'); ?>">
        <span>Retrait</span>
        <strong>Retirer des fonds</strong>
        <p>Consultez le frais avant validation.</p>
    </a>

    <a class="client-action-card" href="<?= base_url('/client/transfert'); ?>">
        <span>Transfert</span>
        <strong>Envoyer a un destinataire</strong>
        <p>Transfert rapide vers un numero valide.</p>
    </a>

    <a class="client-action-card" href="<?= base_url('/client/historique'); ?>">
        <span>Historique</span>
        <strong>Voir les operations</strong>
        <p>Retrouvez tous vos mouvements de compte.</p>
    </a>
</div>
<?php
$content = ob_get_clean();

echo view('client/_layout', [
    'title' => 'Accueil client',
    'pageHeading' => 'Bienvenue a vous',
    'pageDescription' => 'Consultez votre solde et accedez directement aux operations principales.',
    'activeMenu' => 'home',
    'clientName' => $numero ?: 'Client',
    'soldeValue' => $solde,
    'content' => $content,
]);